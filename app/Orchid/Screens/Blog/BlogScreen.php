<?php

namespace App\Orchid\Screens\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BlogScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'blog' => Blog::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'BlogScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить блог')
                ->modal('createBlog')
                ->method('storeBlog')
                ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('blog', [
                TD::make('title', 'Заголовок'),
                TD::make('body', 'Содержание'),
                TD::make('image', 'Картинка')->render(function ($blog) {
                    if ($blog->image) {
                        return '<img src="' . $blog->image . '" style="width: 100px; height: auto;" />';
                    } else {
                        return 'Нет картинки';
                    }
                }),
                TD::make('created_at', 'Дата создание')
            ]),
            Layout::modal('createBlog', [
                Layout::rows([
                    Input::make('blog.title')->title('Заголовок')->required(),
                    Input::make('blog.body')->title('Содержание')->required(),
                    Upload::make('blog.image')->title('Картинка')->required(),
                ])
            ])->title('Создание блога')
                ->applyButton('Сохранить'),
        ];
    }

    public function storeBlog(Request $request)
    {
        $validate = $request->validate([
            'blog.title' => 'required',
            'blog.body' => 'required',
            'blog.image' => 'required',
        ]);
        $attachmentIds = $request->input('blog.image');
        $attachmentId = $attachmentIds[0];
        $attachment = Attachment::find($attachmentId);
        $attachment_url = $attachment->relativeUrl;
        Blog::create([
            'title' => $request->input('blog.title'),
            'body' => $request->input('blog.body'),
            'image' => $attachment_url,
        ]);
        Toast::info('Блог успешно создан!');
    }
}
