<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ContactRequest;

class PlatformController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        if ($request->user()->isManager()) {
            return $this->renderManagerView();
        }

        return $this->renderClientView();
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        if (Application::checkIfAlreadyPlaced(auth()->id())) {
            return redirect()
                ->back()
                ->with(['error' => 'You can place only 1 application per day']);
        }
        
        $path = FileService::handle($request->file('attachment'));

        try {
            Application::query()
                ->create(array_merge(
                    $request->validated(),
                    [
                        'user_id' => $request->user()->id,
                        'file' => $path,
                    ]
                ));

            return redirect()
                ->back()
                ->with(['success' => trans('clients.alerts.success')]);
        } catch (Throwable $t) {
            logger()->error($t->getMessage());

            return redirect()
                ->back()
                ->withInput($request->all())
                ->with([
                    'error' => trans('clients.alerts.error'),
                ]);
        }
    }

    /**
     * @return string
     */
    private function renderClientView(): string
    {
        return view('platform.client.index')->render();
    }

    /**
     * @return string
     */
    private function renderManagerView(): string
    {
        return view('platform.manager.index', [
            'applications' => Application::getPaginated()
        ])->render();
    }
}
