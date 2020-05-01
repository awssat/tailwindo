<?php

namespace Awssat\Tailwindo\Framework;

class BootstrapFramework implements Framework
{
    protected $mediaOptions = [
        'xs' => 'sm',
        'sm' => 'sm',
        'md' => 'md',
        'lg' => 'lg',
        'xl' => 'xl',
        'print' => 'print',
    ];

    protected $grid = [
        '1'  => '1/6',
        '2'  => '1/5',
        '3'  => '1/4',
        '4'  => '1/3',
        '5'  => '2/5',
        '6'  => '1/2',
        '7'  => '3/5',
        '8'  => '2/3',
        '9'  => '3/4',
        '10' => '4/5',
        '11' => '5/6',
        '12' => 'full',
    ];

    protected $colors = [
        'primary'   => 'blue-600',
        'secondary' => 'gray-600',
        'success'   => 'green-500',
        'danger'    => 'red-600',
        'warning'   => 'yellow-500',
        'info'      => 'teal-500',
        'light'     => 'gray-100',
        'dark'      => 'black',
        'white'     => 'white',
        'muted'     => 'gray-500',
    ];


    public function supportedVersion(): string
    {
        /**
         * latest version of Bootstrap during the coding of this file.
         */
        return '4.4.1';
    }

    /**
     * This is the default css classes to be added to your main css file for compatibility 
     */
    public function defaultCSS(): array
    {
        return [
            //https://getbootstrap.com/docs/4.4/content/reboot/
            'h1' => '',
            //... 
            'fieldset' => '',

            //https://getbootstrap.com/docs/4.4/content/typography/
            'del' => '',
            //..
        ];
    }

    /**
     * .get all convertible items 
     */
    public function get(): \Generator
    {
        foreach([
        'general',
        'grid',
        'borders',
        'mediaObject',
        'colors',
        'display',
        'sizing',
        'flexElements',
        'spacing',
        'text',
        'floats',
        'positioning',
        'visibility',
        'alerts',
        'verticalAlignment',
        'badges',
        'breadcrumb',
        'buttons',
        'cards',
        'dropdowns',
        'forms',
        'inputGroups',
        'listGroups',
        'modals',
        'navs',
        'pagination'
        ] as $component) {
            yield $this->$component();
        }
    }

    protected function general(): array
    {
        $mainClasses = [
                'container-fluid' => 'container mx-auto',
                'container'       => 'container mx-auto',

                //http://getbootstrap.com/docs/4.0/utilities/close-icon/
                'close' => 'p-0 bg-transparent border-0 appearance-none',

                //http://getbootstrap.com/docs/4.0/utilities/embed/
                'embed-responsive'       => '',
                'embed-responsive-item'  => '',
                'embed-responsive-21by9' => '',
                'embed-responsive-16by9' => '',
                'embed-responsive-4by3'  => '',
                'embed-responsive-1by1'  => '',

                // http://getbootstrap.com/docs/4.0/utilities/image-replacement/
                'text-hide' => '',

                // http://getbootstrap.com/docs/4.0/utilities/screenreaders/
                // 'sr-only'           => 'sr-only',
                'sr-only-focusable' => 'focus:not-sr-only',

                // http://getbootstrap.com/docs/4.0/content/images/
                'img-fluid'     => 'max-w-full h-auto',
                'img-thumbnail' => 'max-w-full h-auto border-1 border-gray-200 rounded p-1',

                //http://getbootstrap.com/docs/4.0/content/tables/
                'table'    => 'w-full max-w-full mb-4 bg-transparent',
                'table-sm' => 'p-1',
                // 'table-bordered' => '',
                // 'table-striped' => '',
                'table-responsive'                => 'block w-full overflow-auto scrolling-touch',
                'table-responsive-{regex_string}' => 'block w-full overflow-auto scrolling-touch',

                //http://getbootstrap.com/docs/4.0/content/figures/
                'figure'         => 'inline-block mb-4',
                'figure-img'     => 'mb-2 leading-none',
                'figure-caption' => 'text-gray-',

                'fade'     => 'opacity-0',
                'show'     => 'opacity-100 block', //need to be checked
                'disabled' => 'opacity-75',

                //http://getbootstrap.com/docs/4.0/components/collapse/
                // 'collapse' => 'hidden',
                'collapsing' => 'relative h-0 overflow-hidden ', //there should be a h-0

                'close' => 'absolute top-0 bottom-0 right-0 px-4 py-3',

                //http://getbootstrap.com/docs/4.0/components/jumbotron/
                'jumbotron'       => 'py-8 px-4 mb-8 bg-gray-200 rounded',
                'jumbotron-fluid' => 'pr-0 pl-0 rounded-none',

        ];

        $mainClassesEachScreen = [
            'container-{screen}'       => 'container-{screen} mx-auto',
        ];

        $items = [];
        foreach ($mainClasses as $btClass => $twClass) {
            $items[$btClass] = $twClass;
        }

        foreach ($mainClassesEachScreen as $btClass => $twClass) {
            foreach ($this->mediaOptions as $btMedia => $twMedia) {
                $items[str_replace($btClass, '{screen}', $btMedia)] = str_replace($twMedia, '{screen}', $twMedia);
            }
        }

        return $items;
    }

    protected function grid(): array
    {
        $items =[
            'row' => 'flex flex-wrap',
            'col' => 'flex-grow max-w-full',
        ];

        //col-(xs|sm|md|lg|xl) = (sm|md|lg|xl):flex-grow
        //ml-(xs|sm|md|lg|xl)-auto = (sm|md|lg|xl):mx-auto:ml-auto
        //mr-(xs|sm|md|lg|xl)-auto = (sm|md|lg|xl):mx-auto:mr-auto
        foreach ($this->mediaOptions as $btMedia => $twMedia) {
    
            $items['col-'.$btMedia] = $twMedia.':flex-grow';
            $items['ml-'.$btMedia.'-auto'] = $twMedia.':ml-auto';
            $items['mr-'.$btMedia.'-auto'] = $twMedia.':mr-auto';

            //col-btElem
            //col-(xs|sm|md|lg|xl)-btElem = (sm|md|lg|xl):w-twElem
            //offset-(xs|sm|md|lg|xl)-btElem = (sm|md|lg|xl):mx-auto
            foreach ($this->grid as $btElem => $twElem) {
                if ($btMedia === 'xs') {
                    $items['col-'.$btElem] = 'w-'.$twElem;
                }

                $items['col-'.$btMedia.'-'.$btElem] = $twMedia.':w-'.$twElem.' pr-4 pl-4';

                //might work :)
                $items['offset-'.$btMedia.'-'.$btElem] = $twMedia.':mx-'.$twElem;
            }
        }

        return $items;
    }

    protected function mediaObject(): array
    {
        //http://getbootstrap.com/docs/4.0/layout/media-object/
        return [];
    }

    protected function borders(): array
    {
        $items = [];
    
        foreach ([
            'top' => 't',
            'right' => 'r',
            'bottom' => 'b',
            'left' => 'l',
        ] as $btSide => $twSide) {
            $items['border-'.$btSide] = 'border-'.$twSide;
            $items['border-'.$btSide.'-0'] = 'border-'.$twSide.'-0';
        }

        foreach ($this->colors as $btColor => $twColor) {
            $items['border-'.$btColor] = 'border-'.$twColor;
        }

        foreach ([
                'top' => 't',
                'right' => 'r',
                'bottom' => 'b',
                'left' => 'l',
                'circle' => 'full',
                'pill' => 'full py-2 px-4',
                '0' => 'none',
        ] as $btStyle => $twStyle) {
            $items['rounded-'.$btStyle] = 'rounded-'.$twStyle;
        }
        
        return $items;
    }

    protected function colors(): array
    {
        $items = [];

        foreach ($this->colors as $btColor => $twColor) {
            $items['text-'.$btColor] = 'text-'.$twColor;
            $items['bg-'.$btColor] =  'bg-'.$twColor;
            $items['table-'.$btColor] = 'bg-'.$twColor;
            // $items['bg-gradient-'.$btColor] = 'bg-'.$twColor;
        }

        return $items;
    }

    protected function display(): array
    {
        //.d-none
        //.d-{sm,md,lg,xl}-none
        $items = [];

        foreach ([
                'none' => 'hidden',
                'inline' => 'inline',
                'inline-block' => 'inline-block',
                'block' => 'block',
                'table' => 'table',
                'table-cell' => 'table-cell',
                'table-row' => 'table-row',
                'flex' => 'flex',
                'inline-flex' => 'inline-flex',
        ] as $btElem => $twElem) {
            $items['d-'.$btElem] = $twElem;

            foreach ($this->mediaOptions as $btMedia => $twMedia) {
                $items['d-'.$btMedia.'-'.$btElem] = $twMedia.':'.$twElem;
            }
        }

        return $items;
    }

    protected function flexElements(): array
    {
        $items = [];

        foreach (array_merge($this->mediaOptions, [''=>'']) as $btMedia => $twMedia) {
            foreach (['row', 'row-reverse', 'col', 'col-reverse'] as $key) {
                $items['flex'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key] = (empty($twMedia) ? '' : $twMedia.':').'flex-'.$key;
            }

            foreach (['start', 'end', 'center', 'between', 'around'] as $key) {
                $items['justify-content'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key] = (empty($twMedia) ? '' : $twMedia.':').'justify-'.$key;
            }

            foreach (['start', 'end', 'center', 'stretch', 'baseline'] as $key) {
                $items['align-items'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key] = (empty($twMedia) ? '' : $twMedia.':').'align-'.$key;
            }

            foreach (['start', 'end', 'center', 'stretch', 'baseline'] as $key) {
                $items['align-content'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key] = (empty($twMedia) ? '' : $twMedia.':').'content-'.$key;
            }

            foreach (['start', 'end', 'center', 'stretch', 'baseline'] as $key) {
                $items['align-self'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key] = (empty($twMedia) ? '' : $twMedia.':').'self-'.$key;
            }

            $items['flex'.(empty($btMedia) ? '' : '-').$btMedia.'-wrap'] = (empty($twMedia) ? '' : $twMedia.':').'flex-wrap';
            $items['flex'.(empty($btMedia) ? '' : '-').$btMedia.'-wrap-reverse'] = (empty($twMedia) ? '' : $twMedia.':').'flex-wrap-reverse';
            $items['flex'.(empty($btMedia) ? '' : '-').$btMedia.'-nowrap'] = (empty($twMedia) ? '' : $twMedia.':').'flex-no-wrap';

            $items['flex'.(empty($btMedia) ? '' : '-').$btMedia.'-nowrap'] = (empty($twMedia) ? '' : $twMedia.':').'flex-no-wrap';

            foreach (range(1, 12) as $order) {
                $items['order'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$order] = '';
            }
        }
    
        return $items;
    }

    protected function sizing(): array
    {
        $items = [];

        foreach ([
            '25' => '1/4',
            '50' => '1/2',
            '75' => '3/4',
            '100' => 'full',
        ] as $btClass => $twClass) {
            $items['w-'.$btClass] = 'w-'.$twClass;

            //no percentages in TW for heights except for full
            if ($btClass === '100') {
                $items['h-'.$btClass] = 'h-'.$twClass;
            }
        }

        $items['mw-100'] = 'max-w-full';
        $items['mh-100'] = 'max-h-full';

        return $items;
    }

    protected function spacing(): array
    {
        $items = [];

        foreach ($this->mediaOptions as $btMedia => $twMedia) {
            $items['m-'.$btMedia.'-{regex_number}'] = $twMedia.':m-{regex_number}';
            $items['m{regex_string}-'.$btMedia.'-{regex_number}'] = $twMedia.':m{regex_string}-{regex_number}';
            $items['p-'.$btMedia.'-{regex_number}'] = $twMedia.':p-{regex_number}';
            $items['p{regex_string}-'.$btMedia.'-{regex_number}'] = $twMedia.':p {regex_string}-{regex_number}';
        }

        return $items;
    }

    protected function text(): array
    {
        $items = [
        'text-nowrap' => 'whitespace-no-wrap',
        'text-truncate' => 'truncate',

        'text-lowercase' => 'lowercase',
        'text-uppercase' => 'uppercase',
        'text-capitalize' => 'capitalize',

        'initialism' => '',
        'lead' => 'text-lg font-300',
        'small' => 'text-sm',
        'mark' => '',
        'display-1' => 'text-xl',
        'display-2' => 'text-2xl',
        'display-3' => 'text-3xl',
        'display-4' => 'text-4xl',

        'h-1' => 'mb-2 font-medium leading-tight text-4xl',
        'h-2' => 'mb-2 font-medium leading-tight text-3xl',
        'h-3' => 'mb-2 font-medium leading-tight text-2xl',
        'h-4' => 'mb-2 font-medium leading-tight text-xl',
        'h-5' => 'mb-2 font-medium leading-tight text-lg',
        'h-6' => 'mb-2 font-medium leading-tight text-base',

        'blockquote' => 'mb-6 text-lg',
        'blockquote-footer' => 'block text-gray-',

        'font-weight-bold' => 'font-bold',
        'font-weight-normal' => 'font-normal',
        'font-weight-300' => 'font-300',
        'font-italic' => 'italic',
        ];

        foreach (array_merge($this->mediaOptions, [''=>'']) as $btMedia => $twMedia) {
            $items['text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-left'] = (empty($twMedia) ? '' : $twMedia.':').'text-left';
            $items['text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-right'] = (empty($twMedia) ? '' : $twMedia.':').'text-right';
            $items['text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-center'] = (empty($twMedia) ? '' : $twMedia.':').'text-center';
            $items['text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-justify'] = (empty($twMedia) ? '' : $twMedia.':').'text-justify';
        }

        return $items;
    }

    protected function floats(): array
    {
        $items = [];
    
        foreach ($this->mediaOptions as $btMedia => $twMedia) {
            foreach (['left', 'right', 'none'] as $alignment) {
                $items['float-'.$btMedia.'-'.$alignment] = $twMedia.':float-'.$alignment;
            }
        }

        return $items;
    }

    protected function positioning(): array
    {
        $items = [];

        foreach ([
            'position-static' => 'static',
            'position-relative' => 'relative',
            'position-absolute' => 'absolute',
            'position-fixed' => 'fixed',
            'position-sticky' => '',
            'fixed-top' => 'top-0',
            'fixed-bottom' => 'bottom-0',
        ] as $btPosition => $twPosition) {
            $items[$btPosition] = $twPosition;
        }

        return $items;
    }

    protected function verticalAlignment(): array
    {
        //same
        $items = [];
        // foreach ([
        //     'baseline', 'top', 'middle', 'bottom', 'text-top', 'text-bottom'
        // ] as $btAlign=> $twAlign) {
        //     $items['align-'.$btAlign] = 'align-'.$twAlign;
        // }
        return $items;
    }

    protected function visibility(): array
    {
        //same
        return [];
    }

    protected function alerts()
    {
        $items = [
            'alert' => 'relative px-3 py-3 mb-4 border rounded',
            'alert-heading' => '', //color: inherit
            'alert-link' => 'font-bold no-underline',
            'alert-dismissible' => '',
        ];

        foreach ($this->colors as $btColor => $twColor) {
                $items['alert-'.$btColor] = 'text-'.$twColor.'-800'.' border-'.$twColor.'-700 bg-'.$twColor.'-200';
        }

        return $items;
    }

    protected function badges(): array
    {
        $items = [
        'badge' => 'inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded',
        'badge-pill' => 'rounded-full py-1 px-3',
        ];

        foreach ($this->colors as $btColor => $twColor) {
            if ($btColor === 'dark') {
                $items['badge-'.$btColor] = 'text-white bg-black';
            } elseif ($btColor == 'light') {
                $items['badge-'.$btColor] = 'text-black bg-gray-300';
            } else {
                $items['badge-'.$btColor] = 'text-'.$twColor.'-800'.' bg-'.$twColor.'-300';
            }
        }

        return $items;
    }

    protected function breadcrumb(): array
    {
        return [
        'breadcrumb' => 'flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-gray-200 rounded',
        'breadcrumb-item'=> 'inline-block px-2 py-2 text-gray-700',
        ];
    }

    protected function buttons(): array
    {
        $items = [
        'btn' => 'inline-block align-middle text-center select-none border font-normal whitespace-no-wrap py-2 px-4 rounded text-base leading-normal no-underline',
        'btn-group' => 'relative inline-flex align-middle',
        'btn-group-vertical' => 'relative inline-flex align-middle flex-col items-start justify-center',
        'btn-toolbar' => 'flex flex-wrap justify-start',
        'btn-link' => 'font-normal blue bg-transparent',
        'btn-block' => 'block w-full',
        ];
    
        foreach ([
            'sm' => 'py-1 px-2 text-sm leading-tight',
            'lg' => 'py-3 px-4 text-xl leading-tight',
        ] as $btMedia => $twClasses) {
            $items['btn-'.$btMedia] = $twClasses;
            $items['btn-group-'.$btMedia] = $twClasses;
        }

        foreach ($this->colors as $btColor => $twColor) {
            $items['btn-'.$btColor] = 'text-'.$twColor.'-100 bg-'.$twColor.' hover:bg-'.$twColor.'-300';
            $items['btn-outline-'.$btColor] = 'text-'.$twColor.'-700 border-'.$twColor.' bg-white hover:bg-'.$twColor.'-300 hover:text-'.$twColor.'-800';
        }

        return $items;
    }

    protected function cards(): array
    {
        return [
        'card' => 'relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300',
        'card-body' => 'flex-auto p-6',
        'card-title' => 'mb-3',
        'card-text' => 'mb-0',
        'card-subtitle' => '-mt-2 mb-0',
        'card-link' => 'ml-6',
        'card-header' => 'py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900',
        'card-footer' => 'py-3 px-6 bg-gray-200 border-t-1 border-gray-300',
        'card-header-tabs' => 'border-b-0 -ml-2 -mb-3',
        'card-header-pills' => '-ml-3 -mr-3',
        'card-img-overlay' => 'absolute inset-y-0 inset-x-0 p-6',
        'card-img' => 'w-full rounded',
        'card-img-top' => 'w-full rounded rounded-t',
        'card-img-bottom' => 'w-full rounded rounded-b',
        'card-deck' => 'flex flex-col sm:flex-wrap sm:-ml-1 sm:-mr-1',
        'card-group' => 'flex flex-col',
        ];
    }

    protected function dropdowns(): array
    {
        return [
        'dropdown' => 'relative',
        'dropup' => 'relative',
        'dropdown-toggle' => ' inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1',
        'dropdown-menu' => ' absolute left-0 z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-gray-300 rounded',
        'dropdown-divider' => 'h-0 my-2 overflow-hidden border-t-1 border-gray-300',
        'dropdown-item' => 'block w-full py-1 px-6 font-normal text-gray-900 whitespace-no-wrap border-0',
        'dropdown-header' => 'block py-2 px-6 mb-0 text-sm text-gray-800 whitespace-no-wrap',
        ];
    }

    protected function forms(): array
    {
        return [
        'form-group' => 'mb-4',
        'form-control' => 'block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded',
        'form-control-lg' => 'py-2 px-4 text-lg leading-normal rounded',
        'form-control-sm' => 'py-1 px-2 text-sm leading-normal rounded',
        'form-control-file' => 'block appearance-none',
        'form-control-range' => 'block appearance-none',

        'form-inline' => 'flex items-center',

        'col-form-label' => 'pt-2 pb-2 mb-0 leading-normal',
        'col-form-label-lg' => 'pt-3 pb-3 mb-0 leading-normal',
        'col-form-label-sm' => 'pt-1 pb-1 mb-0 leading-normal',

        'col-form-legend' => 'pt-2 pb-2 mb-0 text-base',
        'col-form-plaintext' => 'pt-2 pb-2 mb-0 leading-normal bg-transparent border-transparent border-r-0 border-l-0 border-t border-b',

        'form-text' => 'block mt-1',
        'form-row' => 'flex flex-wrap -mr-1 -ml-1',
        'form-check' => 'relative block mb-2',
        'form-check-label' => 'text-gray-700 pl-6 mb-0',
        'form-check-input' => 'absolute mt-1 -ml-6',

        'form-check-inline' => 'inline-block mr-2',
        'valid-feedback' => 'hidden mt-1 text-sm text-green',
        'valid-tooltip' => 'absolute z-10 hidden w-4 font-normal leading-normal text-white rounded p-2 bg-green-700',
        'is-valid' => 'bg-green-700',
        'invalid-feedback' => 'hidden mt-1 text-sm text-red',
        'invalid-tooltip' => 'absolute z-10 hidden w-4 font-normal leading-normal text-white rounded p-2 bg-red-700',
        'is-invalid' => 'bg-red-700',
        ];
    }

    protected function inputGroups(): array
    {
        return [
        'input-group' => 'relative flex items-stretch w-full',
        'input-group-addon' => 'py-1 px-2 mb-1 text-base font-normal leading-normal text-gray-900 text-center bg-gray-300 border border-4 border-gray-100 rounded',
        'input-group-addon-lg' => 'py-2 px-3 mb-0 text-lg',
        'input-group-addon-sm' => 'py-3 px-4 mb-0 text-lg',
        ];
    }

    protected function listGroups(): array
    {
        $items = [
        'list-group' => 'flex flex-col pl-0 mb-0 border rounded border-gray-300',
        'list-group-item-action' => 'w-fill',
        'list-group-item' => 'relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-gray-300 no-underline',
        'list-group-flush' => '',
        ];

        foreach ($this->colors as $btColor => $twColor) {
            if ($btColor === 'dark') {
                $items['list-group-item-'.$btColor] = 'text-white bg-gray-700';
            } elseif ($btColor == 'light') {
                $items['list-group-item-'.$btColor] = 'text-black bg-gray-200';
            } else {
                $items['list-group-item-'.$btColor] = 'bg-'.$twColor.'-200 text-'.$twColor.'-900';
            }
        }

        return $items;
    }

    protected function modals(): array
    {
        //TODO
        return [];
    }

    protected function navs(): array
    {
        $items = [
        'nav' => 'flex flex-wrap list-none pl-0 mb-0',
        'nav-tabs' => 'border border-t-0 border-r-0 border-l-0 border-b-1 border-gray-200',
        'nav-pills' => '',
        'nav-fill' => '',
        'nav-justified' => '',
        ];

        $items['nav-link'] = function() {
            $navLinkClasses = 'inline-block py-2 px-4 no-underline';
            if ($this->isInLastSearches('nav-tabs', 5)) {
                $navLinkClasses .= ' border border-b-0 mx-1 rounded rounded-t';
            } else if ($this->isInLastSearches('nav-pills', 5)) {
                $navLinkClasses .= ' border border-blue bg-blue rounded text-white mx-1';
            }
            return $navLinkClasses;
        };
    
        $items['nav-item'] = function() {

            $navItemClasses = '';

            if ($this->isInLastSearches('nav-tabs', 5)) {
                $navItemClasses .= '-mb-px';
            } else if ($this->isInLastSearches('nav-fill', 5)) {
                $navItemClasses .= ' flex-auto text-center';
            } else if ($this->isInLastSearches('nav-justified', 5)) {
                $navItemClasses .= ' flex-grow text-center';
            }
    
            return $navItemClasses;
        };

        $items['navbar'] = 'relative flex flex-wrap items-center content-between py-2 px-4';
        $items['navbar-brand'] = 'inline-block pt-1 pb-1 mr-4 text-lg whitespace-no-wrap';
        $items['navbar-nav'] = 'flex flex-wrap list-reset pl-0 mb-0';
        $items['navbar-text'] = 'inline-block pt-2 pb-2';
        $items['navbar-collapse'] = 'flex-grow items-center';
        $items['navbar-expand'] = 'flex-no-wrap content-start';
        $items['navbar-expand-{regex_string}'] = '';
        $items['navbar-toggler'] = 'py-1 px-2 text-md leading-normal bg-transparent border border-transparent rounded';

        return $items;
    }

    protected function pagination(): array
    {
        return [
        'pagination' => 'flex list-reset pl-0 rounded',
        'pagination-lg' => 'text-xl',
        'pagination-sm' => 'text-sm',
        'page-link' => 'relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-gray-200 no-underline hover:text-blue-800 hover:bg-gray-200',
        // 'page-link' => 'relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-gray-',
        ];
    }
}