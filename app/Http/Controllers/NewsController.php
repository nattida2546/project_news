<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = Auth::user()->role === 'admin'
            ? News::latest()->get()
            : News::where('user_id', Auth::id())->latest()->get();

        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'publish_date' => 'required|date',
        ]);

        News::create([
            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'publish_date' => $request->publish_date,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('news.index')->with('success', 'เพิ่มข่าวสำเร็จ');
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string',
            'publish_date' => 'required|date',
        ]);

        $news->update($request->all());

        return redirect()->route('news.index')->with('success', 'อัปเดตข่าวแล้ว');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('success', 'ลบข่าวแล้ว');
    }
}
?>