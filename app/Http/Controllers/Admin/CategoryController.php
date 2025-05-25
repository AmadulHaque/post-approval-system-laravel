<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    protected $routeRouteName = 'categories.index';
    public function __construct(private CategoryService $categoryService)
    {}


    public function index(): View
    {
        $categories = $this->categoryService->getCategories();
        return view('backend.pages.category.index', compact('categories'));
    }

    public function create(): View
    {
        return view('backend.pages.category.create');
    }


    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $this->categoryService->createCategory($request->validated());
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Category created successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('categories.create')
                ->with('error', 'Failed to create category: ' . $th->getMessage());
        }
    }


    public function edit(string $id): RedirectResponse|View
    {
        try {
            $category  = $this->categoryService->findCategoryById($id);
            return view('backend.pages.category.edit', compact('category'));
        } catch (ModelNotFoundException $e) {
            abort(404, 'Category not found');
        }catch (\Throwable $th) {
            return redirect()->route($this->routeRouteName)
                ->with('error', 'Failed to edit category: ' . $th->getMessage());
        }
    }

    public function update(CategoryRequest $request, string $id): RedirectResponse
    {
       try {
            $this->categoryService->updateCategory($id, $request->validated());
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Category updated successfully');
       }catch (ModelNotFoundException $e) {
            abort(404, 'Category not found');
        }catch (\Throwable $th) {
            return redirect()->route('categories.edit', $id)
                ->with('error', 'Failed to update category: ' . $th->getMessage());
       }
    }

    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->categoryService->deleteCategory($id);
            return redirect()->route($this->routeRouteName)
                ->with('success', 'Category deleted successfully');
        }catch (ModelNotFoundException $e) {
            abort(404, 'Category not found');
        }catch (\Throwable $th) {
            return redirect()->route($this->routeRouteName)
                ->with('error', 'Failed to deleted category: ' . $th->getMessage());
        }
    }
}
