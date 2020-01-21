// Import global dependencies
import './../bootstrap';

// Import required modules
import Tools from './tools';

// Helpers
export default class Helpers {
   /*
    * Run helpers
    *
    */
   static run(helpers, options = {}) {
       let helperList = {
           'core-bootstrap-tooltip': () => this.coreBootstrapTooltip(),
           'core-bootstrap-popover': () => this.coreBootstrapPopover(),
           'core-bootstrap-tabs': () => this.coreBootstrapTabs(),
           'core-bootstrap-custom-file-input': () => this.coreBootstrapCustomFileInput(),
           'core-toggle-class': () => this.coreToggleClass(),
       };

       if (helpers instanceof Array) {
           for (let index in helpers) {
               if (helperList[helpers[index]]) {
                   helperList[helpers[index]](options);
               }
           }
       } else {
           if (helperList[helpers]) {
               helperList[helpers](options);
           }
       }
   }

    /*
     ********************************************************************************************
     *
     * CORE HELPERS
     *
     * Third party plugin inits or various custom user interface helpers to extend functionality
     * They are called by default and can be used right away
     *
     *********************************************************************************************
     */

    /*
     * Bootstrap Tooltip, for more examples you can check out https://getbootstrap.com/docs/4.3/components/tooltips/
     *
     * Helpers.run('core-bootstrap-tooltip');
     *
     * Example usage:
     *
     * <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Tooltip Text">Example</button> or
     * <button type="button" class="btn btn-primary js-tooltip" title="Tooltip Text">Example</button>
     *
     */
    static coreBootstrapTooltip() {
        jQuery('[data-toggle="tooltip"]:not(.js-tooltip-enabled)').add('.js-tooltip:not(.js-tooltip-enabled)').each((index, element) => {
            let el = jQuery(element);

            // Add .js-tooltip-enabled class to tag it as activated and init it
            el.addClass('js-tooltip-enabled').tooltip({
                container: el.data('container') || 'body',
                animation: el.data('animation') || false
            });
        });
    }

    /*
     * Bootstrap Popover, for more examples you can check out https://getbootstrap.com/docs/4.3/components/popovers/
     *
     * Helpers.run('core-bootstrap-popover');
     *
     * Example usage:
     *
     * <button type="button" class="btn btn-primary" data-toggle="popover" title="Popover Title" data-content="This is the content of the Popover">Example</button> or
     * <button type="button" class="btn btn-primary js-popover" title="Popover Title" data-content="This is the content of the Popover">Example</button>
     *
     */
    static coreBootstrapPopover() {
        jQuery('[data-toggle="popover"]:not(.js-popover-enabled)').add('.js-popover:not(.js-popover-enabled)').each((index, element) => {
            let el = jQuery(element);

            // Add .js-popover-enabled class to tag it as activated and init it
            el.addClass('js-popover-enabled').popover({
                container: el.data('container') || 'body',
                animation: el.data('animation') || false,
                trigger: el.data('trigger') || 'hover focus'
            });
        });
    }

    /*
     * Bootstrap Tab, for examples you can check out https://getbootstrap.com/docs/4.3/components/navs/#tabs
     *
     * Helpers.run('core-bootstrap-tabs');
     *
     * Example usage:
     *
     * Please check out the Tabs page for complete markup examples
     *
     */
    static coreBootstrapTabs() {
        jQuery('[data-toggle="tabs"]:not(.js-tabs-enabled)').add('.js-tabs:not(.js-tabs-enabled)').each((index, element) => {
            // Add .js-tabs-enabled class to tag it as activated and init it
            jQuery(element).addClass('js-tabs-enabled').find('a').on('click.pixelcave.helpers.core', e => {
                e.preventDefault();
                jQuery(e.currentTarget).tab('show');
            });
        });
    }

    /*
     * Bootstrap Custom File Input Filename
     *
     * Helpers.run('core-bootstrap-custom-file-input');
     *
     * Example usage:
     *
     * Please check out the Tabs page for complete markup examples
     *
     */
    static coreBootstrapCustomFileInput() {
        // Populate custom Bootstrap file inputs with selected filename
        jQuery('[data-toggle="custom-file-input"]:not(.js-custom-file-input-enabled)').each((index, element) => {
            let el = jQuery(element);

            // Add .js-custom-file-input-enabled class to tag it as activated
            el.addClass('js-custom-file-input-enabled').on('change', e => {
                let fileName = (e.target.files.length > 1) ? e.target.files.length + ' ' + (el.data('lang-files') || 'Files') : e.target.files[0].name;

                el.next('.custom-file-label').css('overflow-x', 'hidden').html(fileName);
            });
        });
    }

    /*
     * Toggle class on element click
     *
     * Helpers.run('core-toggle-class');
     *
     * Example usage (on button click, "exampleClass" class is toggled on the element with id "elementID"):
     *
     * <button type="button" class="btn btn-primary" data-toggle="class-toggle" data-target="#elementID" data-class="exampleClass">Toggle</button>
     *
     * or
     *
     * <button type="button" class="btn btn-primary js-class-toggle" data-target="#elementID" data-class="exampleClass">Toggle</button>
     *
     */
    static coreToggleClass() {
        jQuery('[data-toggle="class-toggle"]:not(.js-class-toggle-enabled)')
            .add('.js-class-toggle:not(.js-class-toggle-enabled)')
            .on('click.pixelcave.helpers.core', e => {
                let el = jQuery(e.currentTarget);

                // Add .js-class-toggle-enabled class to tag it as activated and then blur it
                el.addClass('js-class-toggle-enabled').blur();

                // Toggle class
                jQuery(el.data('target').toString()).toggleClass(el.data('class').toString());
            });
    }
}
