<?php

namespace Apps\Readme\Model;

use League\CommonMark\{
    CommonMarkConverter,
    Output\RenderedContentInterface
};

final class Generator
{
    private string | null $title;
    private string | null $description;
    private array | null $authors;
    private array | null $authorLinks;

    private CommonMarkConverter $converter;
    private string $markdown;

    public function __construct(private array $options)
    {
        // Estableciendo las propiedades que rellenarán el markdown
        // a partir del array asociativo superglobal $_POST
        $this->title = self::get($options, 'title');
        $this->description = self::get($options, 'description');
        $this->authors = self::get($options, 'authors');
        $this->authorLinks = self::get($options, 'author_links');

        $this->converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    public function generate(): void
    {
        $this->markdown = '';
        $this->markdown .= $this->createMarkdown('title', $this->title);
        $this->markdown .= $this->createMarkdown('description', $this->description);
        $this->markdown .= $this->createMarkdown('authors', ['authors' => $this->authors, 'links' => $this->authorLinks]);
    }

    private function createMarkdown(string $prop, string | array | null $value): string
    {
        if (is_null($value) || $value == '') {
            return '';
        }

        switch ($prop) {
            case 'title':
                return "\n# $value\n";
            case 'description':
                return "## $value\n";
            case 'authors':
                $mk = $this->processAuthors($value);
                return "$mk";

            default:
                return '';
        }
    }

    private function processAuthors(array $value): string
    {
        $mk = "### Authors:\n";

        // Se fuerza a tipo array haciendo un casteo
        $authors = (array) $value['authors'];
        $links = (array) $value['links'];

        // Cada author debería ir aparejado con un link, si no
        // daría un error. Por tanto, habría que manejar eso en el frontend
        for ($i = 0; $i < count($authors); $i++) {
            $author = $authors[$i];
            $link = $links[$i];

            $mk .= "- [$author]($link)\n";
        }

        return $mk;
    }

    public function getMarkdown(): string
    {
        return nl2br($this->markdown);
    }

    // RenderedContentInterface implementa Stringable
    // https://www.php.net/manual/en/class.stringable.php
    public function getHTML(): RenderedContentInterface
    {
        return $this->converter->convert($this->markdown);
    }

    public static function get(array $arr, string $index): string | array | null
    {
        if (isset($arr[$index])) {
            return $arr[$index];
        } else {
            return null;
        }
    }

    public static function getValue(object | null $obj, string $getter): string | array
    {
        if (isset($obj)) {
            return $obj->{$getter}();
        } else {
            return '';
        }
    }

    // getters & setters

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAuthorsAndLinks(): array
    {
        $arr = [];

        $authors = $this->authors;
        $links = $this->authorLinks;

        // Generamos un array de arrays
        for ($i = 0; $i < count($authors); $i++) {
            $author = $authors[$i];
            $link = $links[$i];

            $item = [
                'author' => $author,
                'link' => $link
            ];

            array_push($arr, $item);
        }

        return $arr;
    }
}
