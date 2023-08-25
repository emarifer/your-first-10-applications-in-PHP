<?php

namespace Apps\Blog\model;

use Error;
use League\CommonMark\CommonMarkConverter;

class Post
{
    public function __construct(private string $file)
    {
        // $this->getFileName();
    }

    public function getContent(): array
    {
        $converter = new CommonMarkConverter();
        // ['html_input' => 'escape', 'allow_unsafe_links' => false]

        if (file_exists($this->getFileName())) {
            // Obteniendo el título del post (primera línea)
            // https://stackoverflow.com/questions/4521936/quickest-way-to-read-first-line-from-file
            $first_line = trim(str_replace('#', '', fgets(fopen($this->getFileName(), 'r'))));
            // Obteniendo el contenido del post
            $stream = fopen($this->getFileName(), 'r');
            $content = fread($stream, filesize($this->getFileName()));
            // return $converter->convert($content);
            return [
                'title' => $first_line,
                'content' => $converter->convert($content),
            ];
        } else {
            $this->getFileNameWithoutDash();
            if (file_exists($this->getFileName())) {
                // Obteniendo el título del post (primera línea)
                $first_line = trim(str_replace('#', '', fgets(fopen($this->getFileName(), 'r'))));
                // Obteniendo el contenido del post
                $stream = fopen($this->getFileName(), 'r');
                $content = fread($stream, filesize($this->getFileName()));
                // return $converter->convert($content);
                return [
                    'title' => $first_line,
                    'content' => $converter->convert($content),
                ];
            }
        }

        throw new Error('File does not exist');
    }

    public function getFileName(): string
    {
        $dir = Url::getRootPath();

        return "{$dir}/entries/{$this->file}";
    }

    public  static function getPosts(): array
    {
        $posts = [];
        $files = scandir(Url::getRootPath() . '/entries');

        foreach ($files as $file) {
            if (str_contains($file, '.md')) {
                $post = new Post($file);
                array_push($posts, $post);
            }
        }

        return $posts;
    }

    public function getUrl(): string
    {
        $url = substr($this->file, 0, strpos($this->file, '.md'));
        $title = str_replace(' ', '-', $url);
        return "?post={$title}";
    }

    private function getFileNameWithoutDash(): string
    {
        $fileNameUpdated = str_replace('-', ' ', $this->file);
        $this->file = $fileNameUpdated;

        return $fileNameUpdated;
    }

    public function getPostName(): string
    {
        $title = $this->file;
        $title = str_replace('-', ' ', $title);
        $title = str_replace('.md', '', $title);

        return $title;
    }
}
