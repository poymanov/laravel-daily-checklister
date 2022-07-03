<?php

namespace App\Http\Controllers;

use App\Enums\PageTypeEnum;
use App\Services\Page\Contracts\PageServiceContract;
use App\Services\Page\Exceptions\PageNotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

class PageController
{
    public function __construct(private PageServiceContract $pageService)
    {
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function welcome()
    {
        try {
            $page = $this->pageService->findOneByType(PageTypeEnum::WELCOME);

            return view('page.welcome.page', compact('page'));
        } catch (PageNotFoundException) {
            return view('page.welcome.default');
        } catch (Throwable $e) {
            Log::error($e);

            return redirect()->route('welcome')->with('alert.error', 'Something went wrong');
        }
    }
}
