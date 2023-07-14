<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class OptionSelector extends Component
{
    public string $url;
    public string $parameterName;
    public Collection $options;
    public string $displayingProperty;
    public string $passingProperty;
    public string $allOptionsSelector;
    public ?string $notSpecifiedOptionSelector;

    /**
     * Create a new component instance.
     *
     * @param string      $url
     * @param string      $parameterName
     * @param Collection  $options
     * @param string      $displayingProperty
     * @param string      $passingProperty
     * @param string      $allOptionsSelector
     * @param string|null $notSpecifiedOptionSelector
     */
    public function __construct(
        string $url,
        string $parameterName,
        Collection $options,
        string $displayingProperty,
        string $passingProperty,
        string $allOptionsSelector,
        ?string $notSpecifiedOptionSelector = null
    ) {
        $this->url = $url;
        $this->parameterName = $parameterName;
        $this->options = $options;
        $this->displayingProperty = $displayingProperty;
        $this->passingProperty = $passingProperty;
        $this->allOptionsSelector = $allOptionsSelector;
        $this->notSpecifiedOptionSelector = $notSpecifiedOptionSelector;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.option-selector');
    }
}
