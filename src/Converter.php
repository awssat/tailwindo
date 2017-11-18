<?php

namespace Awssat\Tailwindo;

class Converter
{
    protected $givenContent = '';

    protected $isCssClassesOnly = false;

    protected $changes = 0;

    protected $lastSearches = [];

    protected $mediaOptions = [
        'xs' => 'sm',
        'sm' => 'sm',
        'md' => 'md',
        'lg' => 'lg',
        'xl' => 'xl',
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
        'primary'   => 'blue',
        'secondary' => 'grey',
        'success'   => 'green',
        'danger'    => 'red',
        'warning'   => 'yellow',
        'info'      => 'teal',
        'light'     => 'grey-lightest',
        'dark'      => 'black',
        'white'     => 'white',
        'muted'     => 'grey',
    ];

    /**
     * initiate the converter class.
     *
     * @param string $content
     *
     * @return Converter
     */
    public function __construct($content = null)
    {
        if (!empty($given)) {
            $this->givenContent = $content;
        }

        return $this;
    }

    /**
     * Set the content.
     *
     * @param string $content
     *
     * @return Converter
     */
    public function setContent(string $content)
    {
        $this->givenContent = $content;

        return $this;
    }

    /**
     * Is the given content a CSS content or HTML content.
     *
     * @param bool $value
     *
     * @return Converter
     */
    public function classesOnly(bool $value)
    {
        $this->isCssClassesOnly = $value;

        return $this;
    }

    /**
     * Run the conversion.
     *
     * @return Converter
     */
    public function convert()
    {
        $this->convertGeneral();
        $this->convertGrid();
        $this->convertBorders();
        $this->convertMediaObject();
        $this->convertColors();
        $this->convertDisplay();
        $this->convertSizing();
        $this->convertFlexElements();
        $this->convertSpacing();
        $this->convertText();
        $this->convertFloats();
        $this->convertPositioning();
        $this->convertVisibility();
        $this->convertAlerts();
        $this->convertVerticalAlignment();
        $this->convertBadges();
        $this->convertBreadcrumb();
        $this->convertButtons();
        $this->convertCards();
        $this->convertDropdowns();
        $this->convertForms();
        $this->convertInputGroups();
        $this->convertListGroups();
        $this->convertModals();
        $this->convertNavs();
        $this->convertPagination();

        return $this;
    }

    /**
     * Get the converted content.
     *
     * @return string
     */
    public function get()
    {
        return $this->givenContent;
    }

    /**
     * Get the number of comitted changes.
     *
     * @return int
     */
    public function changes()
    {
        return $this->changes;
    }

    /**
     * Convert main elements.
     *
     * @return null
     */
    protected function convertGeneral()
    {
        $mainClasses = [
                'container-fluid' => 'container mx-auto',
                'container'       => 'container mx-auto',

                //http://getbootstrap.com/docs/4.0/utilities/close-icon/
                'close' => '',

                //http://getbootstrap.com/docs/4.0/utilities/embed/
                'embed-responsive'       => '',
                'embed-responsive-item'  => '',
                'embed-responsive-21by9' => '',
                'embed-responsive-16by9' => '',
                'embed-responsive-4by3'  => '',
                'embed-responsive-1by1'  => '',

                //http://getbootstrap.com/docs/4.0/utilities/image-replacement/
                'text-hide' => '',

                //http://getbootstrap.com/docs/4.0/utilities/screenreaders/
                'sr-only'           => '',
                'sr-only-focusable' => '',

                //http://getbootstrap.com/docs/4.0/content/images/
                'img-fluid'     => 'max-w-full h-auto',
                'img-thumbnail' => 'max-w-full h-auto border-1 border-grey rounded p-1',

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
                'figure-caption' => 'text-grey',

                'fade'     => 'opacity-0',
                'show'     => 'opacity-100 block', //need to be checked
                'disabled' => 'opacity-75',

                //http://getbootstrap.com/docs/4.0/components/collapse/
                // 'collapse' => 'hidden',
                'collapsing' => 'relative h-0 overflow-hidden ', //there should be a h-0

                'close' => 'absolute pin-t pin-b pin-r px-4 py-3',

                //http://getbootstrap.com/docs/4.0/components/jumbotron/
                'jumbotron'       => 'py-8 px-4 mb-8 bg-grey-lighter rounded',
                'jumbotron-fluid' => 'pr-0 pl-0 rounded-none',

        ];

        $mainClassesEachScreen = [
                //name-{screen}-someting
        ];

        foreach ($mainClasses as $btClass => $twClass) {
            $this->searchAndReplace($btClass, $twClass);
        }

        foreach ($mainClassesEachScreen as $btClass => $twClass) {
            foreach ($this->mediaOptions as $btMedia => $twMedia) {
                $this->searchAndReplace(
                        str_replace($btClass, '{screen}', $btMedia),
                        str_replace($twMedia, '{screen}', $twMedia)
                );
            }
        }
    }

    /**
     * Convert grid elements.
     *
     * @return null
     */
    protected function convertGrid()
    {
        $this->searchAndReplace('row', 'flex flex-wrap');
        $this->searchAndReplace('col', 'flex-grow');

        //col-(xs|sm|md|lg|xl) = (sm|md|lg|xl):flex-grow
        //ml-(xs|sm|md|lg|xl)-auto = (sm|md|lg|xl):mx-auto:ml-auto
        //mr-(xs|sm|md|lg|xl)-auto = (sm|md|lg|xl):mx-auto:mr-auto
        foreach ($this->mediaOptions as $btMedia => $twMedia) {
            $this->searchAndReplace('col-'.$btMedia, $twMedia.':flex-grow');
            $this->searchAndReplace('ml-'.$btMedia.'-auto', $twMedia.':ml-auto');
            $this->searchAndReplace('mr-'.$btMedia.'-auto', $twMedia.':mr-auto');

            //col-btElem
            //col-(xs|sm|md|lg|xl)-btElem = (sm|md|lg|xl):w-twElem
            //offset-(xs|sm|md|lg|xl)-btElem = (sm|md|lg|xl):mx-auto
            foreach ($this->grid as $btElem => $twElem) {
                if ($btMedia === 'xs') {
                    $this->searchAndReplace('col-'.$btElem, 'w-'.$twElem);
                }

                $this->searchAndReplace('col-'.$btMedia.'-'.$btElem, $twMedia.':w-'.$twElem.' pr-4 pl-4');

                //might work :)
                $this->searchAndReplace('offset-'.$btMedia.'-'.$btElem, $twMedia.':mx-'.$twElem);
            }
        }
    }

    protected function convertMediaObject()
    {
        //http://getbootstrap.com/docs/4.0/layout/media-object/
    }

    protected function convertBorders()
    {
        foreach ([
            'top' => 't',
            'right' => 'r',
            'bottom' => 'b',
            'left' => 'l',
        ] as $btSide => $twSide) {
            $this->searchAndReplace('border-'.$btSide, 'border-'.$twSide);
            $this->searchAndReplace('border-'.$btSide.'-0', 'border-'.$twSide.'-0');
        }

        foreach ($this->colors as $btColor => $twColor) {
            $this->searchAndReplace('border-'.$btColor, 'border-'.$twColor);
        }

        foreach ([
                'top' => 't',
                'right' => 'r',
                'bottom' => 'b',
                'left' => 'l',
                'circle' => 'full',
                '0' => 'none',
        ] as $btStyle => $twStyle) {
            $this->searchAndReplace('rounded-'.$btStyle, 'rounded-'.$twStyle);
        }
    }

    protected function convertColors()
    {
        foreach ($this->colors as $btColor => $twColor) {
            $this->searchAndReplace('text-'.$btColor, 'text-'.$twColor);
            $this->searchAndReplace('bg-'.$btColor, 'bg-'.$twColor);
            $this->searchAndReplace('table-'.$btColor, 'bg-'.$twColor);
            // $this->searchAndReplace('bg-gradient-'.$btColor, 'bg-'.$twColor);
        }
    }

    protected function convertDisplay()
    {
        //.d-none
        //.d-{sm,md,lg,xl}-none

        foreach ([
                'none' => 'hidden',
                'inline' => 'inline',
                'inline-block' => 'inline-block',
                'block' => 'block',
                'table' => 'table',
                'table-cell' => 'table-cell',
                'flex' => 'flex',
                'inline-flex' => 'inline-flex',
        ] as $btElem => $twElem) {
            $this->searchAndReplace('d-'.$btElem, $twElem);

            foreach ($this->mediaOptions as $btMedia => $twMedia) {
                $this->searchAndReplace('d-'.$btMedia.'-'.$btElem, $twMedia.':'.$twElem);
            }
        }
    }

    protected function convertFlexElements()
    {
        foreach (array_merge($this->mediaOptions, [''=>'']) as $btMedia => $twMedia) {
            foreach (['row', 'row-reverse', 'col', 'col-reverse'] as $key) {
                $this->searchAndReplace('flex'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key, (empty($twMedia) ? '' : $twMedia.':').'flex-'.$key);
            }

            foreach (['start', 'end', 'center', 'between', 'around'] as $key) {
                $this->searchAndReplace('justify-content'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key, (empty($twMedia) ? '' : $twMedia.':').'justify-'.$key);
            }

            foreach (['start', 'end', 'center', 'stretch', 'baseline'] as $key) {
                $this->searchAndReplace('align-items'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key, (empty($twMedia) ? '' : $twMedia.':').'align-'.$key);
            }

            foreach (['start', 'end', 'center', 'stretch', 'baseline'] as $key) {
                $this->searchAndReplace('align-content'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key, (empty($twMedia) ? '' : $twMedia.':').'content-'.$key);
            }

            foreach (['start', 'end', 'center', 'stretch', 'baseline'] as $key) {
                $this->searchAndReplace('align-self'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$key, (empty($twMedia) ? '' : $twMedia.':').'self-'.$key);
            }

            $this->searchAndReplace('flex'.(empty($btMedia) ? '' : '-').$btMedia.'-wrap', (empty($twMedia) ? '' : $twMedia.':').'flex-wrap');
            $this->searchAndReplace('flex'.(empty($btMedia) ? '' : '-').$btMedia.'-wrap-reverse', (empty($twMedia) ? '' : $twMedia.':').'flex-wrap-reverse');
            $this->searchAndReplace('flex'.(empty($btMedia) ? '' : '-').$btMedia.'-nowrap', (empty($twMedia) ? '' : $twMedia.':').'flex-no-wrap');

            $this->searchAndReplace('flex'.(empty($btMedia) ? '' : '-').$btMedia.'-nowrap', (empty($twMedia) ? '' : $twMedia.':').'flex-no-wrap');

            foreach (range(1, 12) as $order) {
                $this->searchAndReplace('order'.(empty($btMedia) ? '' : '-').$btMedia.'-'.$order, '');
            }
        }
    }

    protected function convertSizing()
    {
        foreach ([
            '25' => '1/4',
            '50' => '1/2',
            '75' => '3/4',
            '100' => 'full',
        ] as $btClass => $twClass) {
            $this->searchAndReplace('w-'.$btClass, 'w-'.$twClass);

            //no percentages in TW for heights except for full
            if ($btClass === '100') {
                $this->searchAndReplace('h-'.$btClass, 'h-'.$twClass);
            }
        }

        $this->searchAndReplace('mw-100', 'max-w-full');
        $this->searchAndReplace('mh-100', 'max-h-full');
    }

    protected function convertSpacing()
    {
        foreach ($this->mediaOptions as $btMedia => $twMedia) {
            $this->searchAndReplace('m-'.$btMedia.'-{regex_number}', $twMedia.':m-{regex_number}');
            $this->searchAndReplace('m{regex_string}-'.$btMedia.'-{regex_number}', $twMedia.':m{regex_string}-{regex_number}');
            $this->searchAndReplace('p-'.$btMedia.'-{regex_number}', $twMedia.':p-{regex_number}');
            $this->searchAndReplace('p{regex_string}-'.$btMedia.'-{regex_number}', $twMedia.':p {regex_string}-{regex_number}');
        }
    }

    protected function convertText()
    {
        foreach (array_merge($this->mediaOptions, [''=>'']) as $btMedia => $twMedia) {
            $this->searchAndReplace('text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-left', (empty($twMedia) ? '' : $twMedia.':').'text-left');
            $this->searchAndReplace('text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-right', (empty($twMedia) ? '' : $twMedia.':').'text-right');
            $this->searchAndReplace('text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-center', (empty($twMedia) ? '' : $twMedia.':').'text-center');
            $this->searchAndReplace('text'.(empty($btMedia) ? '' : '-').'-'.$btMedia.'-justify', (empty($twMedia) ? '' : $twMedia.':').'text-justify');
        }

        $this->searchAndReplace('text-nowrap', 'whitespace-no-wrap');
        $this->searchAndReplace('text-truncate', 'truncate');

        $this->searchAndReplace('text-lowercase', 'lowercase');
        $this->searchAndReplace('text-uppercase', 'uppercase');
        $this->searchAndReplace('text-capitalize', 'capitalize');

        $this->searchAndReplace('initialism', '');
        $this->searchAndReplace('lead', 'text-lg font-light');
        $this->searchAndReplace('small', 'text-sm');
        $this->searchAndReplace('mark', '');
        $this->searchAndReplace('display-1', 'text-xl');
        $this->searchAndReplace('display-2', 'text-2xl');
        $this->searchAndReplace('display-3', 'text-3xl');
        $this->searchAndReplace('display-4', 'text-4xl');

        $this->searchAndReplace('h-1', 'mb-2 font-medium leading-tight text-4xl');
        $this->searchAndReplace('h-2', 'mb-2 font-medium leading-tight text-3xl');
        $this->searchAndReplace('h-3', 'mb-2 font-medium leading-tight text-2xl');
        $this->searchAndReplace('h-4', 'mb-2 font-medium leading-tight text-xl');
        $this->searchAndReplace('h-5', 'mb-2 font-medium leading-tight text-lg');
        $this->searchAndReplace('h-6', 'mb-2 font-medium leading-tight text-base');

        $this->searchAndReplace('blockquote', 'mb-6 text-lg');
        $this->searchAndReplace('blockquote-footer', 'block text-grey');

        $this->searchAndReplace('font-weight-bold', 'font-bold');
        $this->searchAndReplace('font-weight-normal', 'font-normal');
        $this->searchAndReplace('font-weight-light', 'font-light');
        $this->searchAndReplace('font-italic', 'italic');
    }

    protected function convertFloats()
    {
        foreach ($this->mediaOptions as $btMedia => $twMedia) {
            foreach (['left', 'right', 'none'] as $alignment) {
                $this->searchAndReplace('float-'.$btMedia.'-'.$alignment, $twMedia.':float-'.$alignment);
            }
        }
    }

    protected function convertPositioning()
    {
        foreach ([
            'position-static' => 'static',
            'position-relative' => 'relative',
            'position-absolute' => 'absolute',
            'position-fixed' => 'fixed',
            'position-sticky' => '',
            'fixed-top' => 'pin-t',
            'fixed-bottom' => 'pin-b',
        ] as $btPosition => $twPosition) {
            $this->searchAndReplace($btPosition, $twPosition);
        }
    }

    protected function convertVerticalAlignment()
    {
        //same
        // foreach ([
        //     'baseline', 'top', 'middle', 'bottom', 'text-top', 'text-bottom'
        // ] as $btAlign=> $twAlign) {
        //     $this->searchAndReplace('align-'.$btAlign, 'align-'.$twAlign);
        // }
    }

    protected function convertVisibility()
    {
        //same
    }

    protected function convertAlerts()
    {
        $this->searchAndReplace('alert', 'relative px-3 py-3 mb-4 border rounded');
        $this->searchAndReplace('alert-heading', ''); //color: inherit
        $this->searchAndReplace('alert-link', 'font-bold no-underline');
        $this->searchAndReplace('alert-dismissible', '');

        foreach ($this->colors as $btColor => $twColor) {
            $this->searchAndReplace('alert-'.$btColor, 'text-'.$twColor.'-darker'.' border-'.$twColor.'-dark bg-'.$twColor.'-lighter');
        }
    }

    protected function convertBadges()
    {
        $this->searchAndReplace('badge', 'inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded');
        $this->searchAndReplace('badge-pill', 'rounded-full py-1 px-3');

        foreach ($this->colors as $btColor => $twColor) {
            if ($btColor === 'dark') {
                $this->searchAndReplace('badge-'.$btColor, 'text-white bg-black');
            } elseif ($btColor == 'light') {
                $this->searchAndReplace('badge-'.$btColor, 'text-black bg-grey-light');
            } else {
                $this->searchAndReplace('badge-'.$btColor, 'text-'.$twColor.'-darker'.' bg-'.$twColor.'-light');
            }
        }
    }

    protected function convertBreadcrumb()
    {
        $this->searchAndReplace('breadcrumb', 'flex flex-wrap list-reset pt-3 pb-3 py-4 px-4 mb-4 bg-grey-light rounded');
        $this->searchAndReplace('breadcrumb-item', 'inline-block px-2 py-2 text-grey-dark');
    }

    protected function convertButtons()
    {
        $this->searchAndReplace('btn', 'inline-block align-middle text-center select-none border font-normal whitespace-no-wrap py-2 px-4 rounded text-base leading-normal no-underline');
        $this->searchAndReplace('btn-group', 'relative inline-flex align-middle');
        $this->searchAndReplace('btn-group-vertical', 'relative inline-flex align-middle flex-col items-start justify-center');
        $this->searchAndReplace('btn-toolbar', 'flex flex-wrap justify-start');
        $this->searchAndReplace('btn-link', 'font-normal blue bg-transparent');
        $this->searchAndReplace('btn-block', 'block w-full');

        foreach ([
            'sm' => 'py-1 px-2 text-sm leading-tight',
            'lg' => 'py-3 px-4 text-xl leading-tight',
        ] as $btMedia => $twClasses) {
            $this->searchAndReplace('btn-'.$btMedia, $twClasses);
            $this->searchAndReplace('btn-group-'.$btMedia, $twClasses);
        }

        foreach ($this->colors as $btColor => $twColor) {
            $this->searchAndReplace('btn-'.$btColor, 'text-'.$twColor.'-lightest bg-'.$twColor.' hover:bg-'.$twColor.'-light');
            $this->searchAndReplace('btn-outline-'.$btColor, 'text-'.$twColor.'-dark border-'.$twColor.' bg-white hover:bg-'.$twColor.'-light hover:text-'.$twColor.'-darker');
        }
    }

    protected function convertCards()
    {
        $this->searchAndReplace('card', 'relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-grey-light');
        $this->searchAndReplace('card-body', 'flex-auto p-6');
        $this->searchAndReplace('card-title', 'mb-3');
        $this->searchAndReplace('card-text', 'mb-0');
        $this->searchAndReplace('card-subtitle', '-mt-2 mb-0');
        $this->searchAndReplace('card-link', 'ml-6');
        $this->searchAndReplace('card-header', 'py-3 px-6 mb-0 bg-grey-lighter border-b-1 border-grey-light text-grey-darkest');
        $this->searchAndReplace('card-footer', 'py-3 px-6 bg-grey-lighter border-t-1 border-grey-light');
        $this->searchAndReplace('card-header-tabs', 'border-b-0 -ml-2 -mb-3');
        $this->searchAndReplace('card-header-pills', '-ml-3 -mr-3');
        $this->searchAndReplace('card-img-overlay', 'absolute pin-y pin-x p-6');
        $this->searchAndReplace('card-img', 'w-full rounded');
        $this->searchAndReplace('card-img-top', 'w-full rounded rounded-t');
        $this->searchAndReplace('card-img-bottom', 'w-full rounded rounded-b');
        $this->searchAndReplace('card-deck', 'flex flex-col sm:flex-wrap sm:-ml-1 sm:-mr-1');
        $this->searchAndReplace('card-group', 'flex flex-col');
    }

    protected function convertDropdowns()
    {
        $this->searchAndReplace('dropdown', 'relative');
        $this->searchAndReplace('dropup', 'relative');
        $this->searchAndReplace('dropdown-toggle', ' inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1');
        $this->searchAndReplace('dropdown-menu', ' absolute pin-l z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-grey-light rounded');
        $this->searchAndReplace('dropdown-divider', 'h-0 my-2 overflow-hidden border-t-1 border-grey-light');
        $this->searchAndReplace('dropdown-item', 'block w-full py-1 px-6 font-normal text-grey-darkest whitespace-no-wrap border-0');
        $this->searchAndReplace('dropdown-header', 'block py-2 px-6 mb-0 text-sm text-greay-dark whitespace-no-wrap');
    }

    protected function convertForms()
    {
        $this->searchAndReplace('form-group', 'mb-4');
        $this->searchAndReplace('form-control', 'block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-grey-darker border border-grey rounded');
        $this->searchAndReplace('form-control-lg', 'py-2 px-4 text-lg leading-normal rouned');
        $this->searchAndReplace('form-control-sm', 'py-1 px-2 text-sm leading-normal rouned');
        $this->searchAndReplace('form-control-file', 'block appearance-none');
        $this->searchAndReplace('form-control-range', 'block appearance-none');

        $this->searchAndReplace('form-inline', 'flex items-center');

        $this->searchAndReplace('col-form-label', 'pt-2 pb-2 mb-0 leading-normal');
        $this->searchAndReplace('col-form-label-lg', 'pt-3 pb-3 mb-0 leading-normal');
        $this->searchAndReplace('col-form-label-sm', 'pt-1 pb-1 mb-0 leading-normal');

        $this->searchAndReplace('col-form-legend', 'pt-2 pb-2 mb-0 text-base');
        $this->searchAndReplace('col-form-plaintext', 'pt-2 pb-2 mb-0 leading-normal bg-transparent border-transparent border-r-0 border-l-0 border-t-1 border-b-1');

        $this->searchAndReplace('form-text', 'block mt-1');
        $this->searchAndReplace('form-row', 'flex flex-wrap -mr-1 -ml-1');
        $this->searchAndReplace('form-check', 'relative block mb-2');
        $this->searchAndReplace('form-check-label', 'text-grey-dark pl-6 mb-0');
        $this->searchAndReplace('form-check-input', 'absolute mt-1 -ml-6');

        $this->searchAndReplace('form-check-inline', 'inline-block mr-2');
        $this->searchAndReplace('valid-feedback', 'hidden mt-1 text-sm text-green');
        $this->searchAndReplace('valid-tooltip', 'absolute z-10 hidden w-4 font-normal leading-noraml text-white rounded p-2 bg-green-dark');
        $this->searchAndReplace('is-valid', 'bg-green-dark');
        $this->searchAndReplace('invalid-feedback', 'hidden mt-1 text-sm text-red');
        $this->searchAndReplace('invalid-tooltip', 'absolute z-10 hidden w-4 font-normal leading-noraml text-white rounded p-2 bg-red-dark');
        $this->searchAndReplace('is-invalid', 'bg-red-dark');
    }

    protected function convertInputGroups()
    {
        $this->searchAndReplace('input-group', 'relative flex items-stretch w-full');
        $this->searchAndReplace('input-group-addon', 'py-1 px-2 mb-1 text-base font-normal leading-normal text-grey-darkest text-center bg-grey-light border border-4 border-grey-lighter rounded');
        $this->searchAndReplace('input-group-addon-lg', 'py-2 px-3 mb-0 text-lg');
        $this->searchAndReplace('input-group-addon-sm', 'py-3 px-4 mb-0 text-lg');
    }

    protected function convertListGroups()
    {
        $this->searchAndReplace('list-group', 'flex flex-col pl-0 mb-0 border rounded border-grey-light');
        $this->searchAndReplace('list-group-item-action', 'w-fill');
        $this->searchAndReplace('list-group-item', 'relative block py-3 px-6 -mb-px border border-r-0 border-l-0 border-grey-light no-underline');
        $this->searchAndReplace('list-group-flush', '');

        foreach ($this->colors as $btColor => $twColor) {
            if ($btColor === 'dark') {
                $this->searchAndReplace('list-group-item-'.$btColor, 'text-white bg-grey-dark');
            } elseif ($btColor == 'light') {
                $this->searchAndReplace('list-group-item-'.$btColor, 'text-black bg-grey-light');
            } else {
                $this->searchAndReplace('list-group-item-'.$btColor, 'bg-'.$twColor.'-lighter text-'.$twColor.'-darkest');
            }
        }
    }

    protected function convertModals()
    {
        //TODO
    }

    protected function convertNavs()
    {
        $this->searchAndReplace('nav', 'flex flex-wrap list-reset pl-0 mb-0');
        $this->searchAndReplace('nav-tabs', 'border border-t-0 border-r-0 border-l-0 border-b-1 border-grey-light');
        $this->searchAndReplace('nav-pills', '');
        $this->searchAndReplace('nav-fill', '');
        $this->searchAndReplace('nav-justified', '');

        $navLinkClasses = 'inline-block py-2 px-4 no-underline';
        $navItemClasses = '';

        if ($this->isInLastSearches('nav-tabs', 5)) {
            $navLinkClasses .= ' border border-b-0 mx-1 rounded rounded-t';
            $navItemClasses .= '-mb-px';
        }

        if ($this->isInLastSearches('nav-pills', 5)) {
            $navLinkClasses .= ' border border-blue bg-blue rounded text-white mx-1';
        }

        if ($this->isInLastSearches('nav-fill', 5)) {
            $navItemClasses .= ' flex-auto text-center';
        }

        if ($this->isInLastSearches('nav-justified', 5)) {
            $navItemClasses .= ' flex-grow text-center';
        }

        $this->searchAndReplace('nav-link', $navLinkClasses);
        $this->searchAndReplace('nav-item', $navItemClasses);

        $this->searchAndReplace('navbar', 'relative flex flex-wrap items-center content-between py-2 px-4');
        $this->searchAndReplace('navbar-brand', 'inline-block pt-1 pb-1 mr-4 text-lg whitespace-nowrap');
        $this->searchAndReplace('navbar-nav', 'flex flex-wrap list-reset pl-0 mb-0');
        $this->searchAndReplace('navbar-text', 'inline-block pt-2 pb-2');
        $this->searchAndReplace('navbar-collapse', 'flex-grow items-center');
        $this->searchAndReplace('navbar-expand', 'flex-no-wrap content-start');
        $this->searchAndReplace('navbar-expand-{regex_string}', '');
        $this->searchAndReplace('navbar-toggler', 'py-1 px-2 text-md leading-normal bg-transparent border border-transparent rounded');
    }

    protected function convertPagination()
    {
        $this->searchAndReplace('pagination', 'flex list-reset pl-0 rounded');
        $this->searchAndReplace('pagination-lg', 'text-xl');
        $this->searchAndReplace('pagination-sm', 'text-sm');
        $this->searchAndReplace('page-link', 'relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-grey no-underline hover:text-blue-darker hover:bg-grey-light');
        // $this->searchAndReplace('page-link', 'relative block py-2 px-3 -ml-px leading-normal text-blue bg-white border border-grey');
    }

    /**
     * search for a word in the last searches.
     *
     * @param string $searchFor
     * @param int    $limitLast limit the search to last $limitLast items
     *
     * @return bool
     */
    protected function isInLastSearches(string $searchFor, $limitLast = 0)
    {
        $i = 0;

        foreach ($this->lastSearches as $search) {
            if (strpos($search, $searchFor) !== false) {
                return true;
            }

            if ($i++ >= $limitLast && $limitLast > 0) {
                return false;
            }
        }

        return false;
    }

    /**
     * Search the given content and replace.
     *
     * @param string $search
     * @param string $replace
     *
     * @return null
     */
    protected function searchAndReplace($search, $replace)
    {
        $currentContent = $this->givenContent;

        $regexStart = !$this->isCssClassesOnly ? '(?<start>class\s*=\s*["\'].*?)' : '(?<start>\s*)';
        $regexEnd = !$this->isCssClassesOnly ? '(?<end>.*?["\'])' : '(?<end>\s*)';

        $search = preg_quote($search);

        $currentSubstitute = 0;

        while (true) {
            if (strpos($search, '\{regex_string\}') !== false || strpos($search, '\{regex_number\}') !== false) {
                $currentSubstitute++;
                foreach (['regex_string'=> '[a-zA-Z0-9]+', 'regex_number' => '[0-9]+'] as $regeName => $regexValue) {
                    $search = preg_replace('/\\\{'.$regeName.'\\\}/', '(?<'.$regeName.'_'.$currentSubstitute.'>'.$regexValue.')', $search, 1);
                    $replace = preg_replace('/{'.$regeName.'\}/', '${'.$regeName.'_'.$currentSubstitute.'}', $replace, 1);
                }

                continue;
            }

            break;
        }

        //class=" given given-md something-given-md"
        $this->givenContent = preg_replace_callback(
            '/'.$regexStart.'(?<given>(?<![\-_.\w\d])'.$search.'(?![\-_.\w\d]))'.$regexEnd.'/i',
             function ($match) use ($replace) {
                 $replace = preg_replace_callback('/\$\{regex_(\w+)_(\d+)\}/', function ($m) use ($match) {
                     return $match['regex_'.$m[1].'_'.$m[2]];
                 }, $replace);

                 return $match['start'].$replace.$match['end'];
             },
             $this->givenContent
         );

        if (strcmp($currentContent, $this->givenContent) !== 0) {
            $this->changes++;

            $this->lastSearches[] = stripslashes($search);

            if (count($this->lastSearches) >= 10) {
                $this->lastSearches = array_slice($this->lastSearches, -10, 10, true);
            }
        }
    }
}
