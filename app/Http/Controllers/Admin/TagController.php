<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller
{
    protected $routeRouteName = 'tags.index';
    public function __construct(private TagService $tagService)
    {}


    public function index(): View
    {
        $tags = $this->tagService->getAll();
        return view('backend.pages.tag.index', compact('tags'));
    }

    public function create(): View
    {
        return view('backend.pages.tag.create');
    }


    public function store(TagRequest $request): RedirectResponse
    {
        try {
            $this->tagService->create($request->validated());
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Tag created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('categories.create')
                ->with('error', 'Failed to create tag : ' . $th->getMessage());
        }
    }


    public function edit(string $id): RedirectResponse|View
    {
        try {
            $tag  = $this->tagService->findById($id);
            return view('backend.pages.tag.edit', compact('tag'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Tag not found');
        }catch (\Throwable $th) {
            return redirect()->route($this->routeRouteName)
                ->with('error', 'Failed to edit tag: ' . $th->getMessage());
        }
    }

    public function update(TagRequest $request, string $id): RedirectResponse
    {
       try {
            $this->tagService->update($id, $request->validated());
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Tag updated successfully');
       }catch (ModelNotFoundException $e) {
            abort(404, 'Tag not found');
        }catch (\Throwable $th) {
            return redirect()->route('tags.edit', $id)
                ->with('error', 'Failed to update tag: ' . $th->getMessage());
       }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->tagService->delete($id);
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Tag deleted successfully');
        }catch (ModelNotFoundException $e) {
            abort(404, 'Tag not found');
        }catch (\Throwable $th) {
            return redirect()->route($this->routeRouteName)
                ->with('error', 'Failed to deleted tag: ' . $th->getMessage());
        }
    }
}
