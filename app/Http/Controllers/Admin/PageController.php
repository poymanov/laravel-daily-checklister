<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PageTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StoreRequest;
use App\Http\Requests\Page\UpdateRequest;
use App\Models\Page;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\Exceptions\PageCreateFailedException;
use App\Services\Page\Exceptions\PageDeleteFailedException;
use App\Services\Page\Exceptions\PageNotFoundException;
use App\Services\Page\Exceptions\PageUpdateFailedException;
use App\Services\Page\Helpers\PageTypeHelper;
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
        $pagesList = PageTypeHelper::getWithTitles();

        return view('admin.page.create', compact('pagesList'));
    }

    /**
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $this->pageService->create($request->get('title'), $request->get('content'), $request->get('type'));

            return redirect()->route('welcome')->with('alert.success', 'Page was created');
        } catch (PageCreateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Page $page)
    {
        try {
            $pageDto = $this->pageService->findOneById($page->id);

            $pagesList = PageTypeHelper::getWithTitles();

            return view('admin.page.edit', ['page' => $pageDto, 'pagesList' => $pagesList]);
        } catch (PageNotFoundException $e) {
            return redirect()->route('welcome')->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param UpdateRequest $request
     * @param Page          $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Page $page)
    {
        try {
            $this->pageService->update($page->id, $request->get('title'), $request->get('content'), $request->get('type'));

            return redirect()->route('admin.pages.show', $page)->with('alert.success', 'Page was updated');
        } catch (PageNotFoundException | PageUpdateFailedException $e) {
            return redirect()->back()->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('welcome')->with('alert.error', 'Something went wrong');
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
            $pageDto = $this->pageService->findOneById($page->id);

            return view('admin.page.show', ['page' => $pageDto]);
        } catch (PageNotFoundException $e) {
            return redirect()->route('welcome')->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('welcome')->with('alert.error', 'Something went wrong');
        }
    }

    /**
     * @param Page $page
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        try {
            $this->pageService->delete($page->id);

            return redirect()->route('welcome')->with('alert.success', 'Page was deleted');
        } catch (PageNotFoundException | PageDeleteFailedException $e) {
            return redirect()->route('welcome')->with('alert.error', $e->getMessage());
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('welcome')->with('alert.error', 'Something went wrong');
        }
    }
}
