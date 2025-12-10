<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    public string $name;
    public string $class;

    public function __construct(string $name, string $class = 'w-5 h-5 stroke-current')
    {
        $this->name  = $name;
        $this->class = $class;
    }

    public function svg()
    {
        return [
            'funnel' => '<path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3c2.2 0 4 1.8 4 4v1.2a3 3 0 001.8 2.7l2.3 1.2A2 2 0 0121 13.8V17a2 2 0 01-2 2h-2M12 9H5a2 2 0 01-2-2V7a4 4 0 014-4h5" />',

            'plus' => '<path stroke-linecap="round" stroke-linejoin="round"
                d="M12 4v16m8-8H4" />',

            'pencil' => '<path stroke-linecap="round" stroke-linejoin="round"
                d="M16.9 4.5l1.6 1.6a2 2 0 010 2.8l-8.3 8.3-4.2 1.4L7 14l8.3-8.3a2 2 0 012.8 0z" />',

            'trash' => '<path stroke-linecap="round" stroke-linejoin="round"
                d="M6 7h12M9 7V4h6v3m-7 4v6m4-6v6m4-6v6m-9 6h10a2 2 0 002-2V9H5v12a2 2 0 002 2z" />',

            'document-text' => '<path stroke-linecap="round" stroke-linejoin="round"
                d="M12 4H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0
                002-2V9l-5-5zm0 0v5h5" />',
        ][$this->name] ?? '';
    }

    public function render()
    {
        return view('components.icon');
    }
}
