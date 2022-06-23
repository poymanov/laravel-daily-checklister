<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StoreRequest;
use App\Models\Page;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

class PageController extends Controller
{
    public function __construct(private PageServiceContract $pageService)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.page.create');
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->pageService->create($request->get('title'), $request->get('content'));

            return redirect()->route('dashboard')->with('alert.success', 'Page was created');
        } catch (PageCreateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Page $page)
    {
        try {
            $page = $this->pageService->findOneById($page->id);

            return view('admin.page.show', compact('page'));
        } catch (PageNotFoundException $e) {
            return redirect()->route('dashboard')->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('dashboard')->with('alert.error', 'Something went wrong');
        }
    }
}
