/**
 * Build styles
 */
require('../../css/ayat.css').toString();

/**
 * @class Ayat
 * @classdesc Ayat Tool for Editor.js
 * @property {AyatData} data - Tool`s input and output data
 * @property {object} api - Editor.js API instance
 *
 * @typedef {object} AyatData
 * @description Quote Tool`s input and output data
 * @property {string} ayatText - ayat`s text
 * @property {string} ayatTextNoDiacritic - quote`s caption
 * @property {'center'|'left'} alignment - quote`s alignment
 *
 * @typedef {object} AyatConfig
 * @description AYAT Tool`s initial configuration
 * @property {string} ayatTextPlaceholder - placeholder to show in Ayat`s text input
 * @property {string} ayatTextNoDiacriticPlaceholder - placeholder to show in ayatTextNoDiacritic input
 * @property {'center'|'left'} defaultAlignment - alignment to use as default
 */
class Ayat {
    /**
     * Notify core that read-only mode is supported
     *
     * @returns {boolean}
     */
    static get isReadOnlySupported() {
        return true;
    }

    /**
     * Get Tool toolbox settings
     * icon - Tool icon's SVG
     * title - title to show in toolbox
     *
     * @returns {{icon: string, title: string}}
     */
    static get toolbox() {
        return {
            icon:`<svg xmlns="http://www.w3.org/2000/svg" width="655.359" height="655.359" fill-rule="evenodd" clip-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 6.827 6.827"><path fill-rule="nonzero" d="M2.001 1.58693c.0358976-.0255433.0442913-.0753543.018748-.111252-.0255433-.0358976-.0753543-.0442913-.111252-.018748l-.427169.302902-.000129921-.000185039c-.0240787.0170748-.0358622.0450354-.0334094.0724606l.00107874 1.66975c0 .0440079.0356811.079689.079689.079689.0440079 0 .079689-.0356811.079689-.079689l-.00105512-1.63568.393811-.279248zM3.01759 4.06052c-.0229528.037622-.0110591.0867362.026563.109689.037622.0229528.0867362.0110591.109689-.026563.0171811-.028189.0517913-.0536024.0979685-.0728504.0504488-.0210315.112783-.033378.180917-.033378.0648976 0 .124488.011185.173559.0303976.0457835.0179252.0811102.042.100831.0692441.0258858.0357244.0758386.0437008.111563.017815.0357244-.0258858.0437008-.0758386.017815-.111563-.0376772-.0520472-.0979094-.0952047-.172083-.124244-.0672362-.0263268-.146909-.0416496-.231685-.0416496-.0892677 0-.172835.0169685-.242169.045874-.0770039.0320984-.138008.079874-.172969.137228z"/><path fill-rule="nonzero" d="M3.4125 3.71222c0.273075,-0.492409 1.11851,-0.591764 1.37942,-0.610878l0 -1.49246c-1.30778,0.122035 -1.29889,0.721492 -1.2989,0.723252l0.000307087 0.000314961c-0.000814961,0.105209 -0.160807,0.103984 -0.159992,-0.00125197l0.00030315 3.93701e-006c-0.000188976,-0.0252126 -0.0178268,-0.60278 -1.29889,-0.722319l0 1.49228c0.261024,0.0185669 1.10701,0.116331 1.37775,0.611059zm0.0801575 0.25385c-0.00648425,0.0626929 -0.0772283,0.0765669 -0.0772283,0.0715945 -0.0413425,0.00250787 -0.0782756,-0.0272402 -0.0840157,-0.0689488l0.000188976 -0.000283465c-0.089815,-0.652508 -1.27622,-0.708374 -1.37289,-0.711862 -0.045685,0.00218898 -0.0839606,-0.0340906 -0.0839606,-0.0799016l0 -1.65449c0,-0.0465591 0.0396772,-0.0834449 0.0859094,-0.0800236l-7.87402e-006 0.000114173c0.960472,0.0712008 1.3189,0.397724 1.45268,0.634492 0.133571,-0.236299 0.491024,-0.562106 1.44767,-0.634083 0.0035748,-0.000488189 0.00721654,-0.000744094 0.0109252,-0.000744094 0.0441811,0 0.08,0.0358189 0.08,0.08l0 1.65412c0,0.201984 -1.34344,0.0100236 -1.45926,0.790016z"/><path fill-rule="nonzero" d="M4.91817 1.45693c-0.0358976,-0.0255433 -0.0857087,-0.0171496 -0.111252,0.018748 -0.0255433,0.0358976 -0.0171496,0.0857087 0.018748,0.111252l0.393453 0.278992 -0.0151496 1.64095c-0.00034252,0.0440079 0.0350551,0.0799724 0.079063,0.080315 0.0440079,0.00034252 0.0799724,-0.0350551 0.080315,-0.079063l0.0154685 -1.67533c0.00270866,-0.0276457 -0.00906693,-0.0559291 -0.0333465,-0.0731457l-0.000129921 0.000185039 -0.427169 -0.302902z"/><path fill-rule="nonzero" d="M5.46871 3.52156l-1.83368 0.706799 0.18528 0.0714173 1.37987 -0.548874c0.0264134,-0.00892913 0.253102,-0.0894488 0.268528,-0.229343zm-2.08406 0.632398l2.12163 -0.817791c0.0105433,-0.00511417 0.022374,-0.00798819 0.034878,-0.00798819 0.0441811,0 0.08,0.0358189 0.08,0.08l0 0.0304528c0.075315,0.321713 -0.37222,0.464567 -0.373516,0.464992l-3.93701e-005 -0.00011811 -1.3908 0.553252c-0.0194882,0.00985039 -0.0429094,0.0117362 -0.0648898,0.00326378l-0.40126 -0.154945c-0.0229921,-0.00681496 -0.0426772,-0.0238425 -0.0519685,-0.0479449 -0.0158898,-0.0412244 0.00464961,-0.0875276 0.045874,-0.103417l9.44882e-005 0.000244094zm-0.379047 0.317016c-0.553358,0.213295 -1.10373,0.426957 -1.6562,0.642665 0.00780315,0.0496772 0.0383465,0.117646 0.148008,0.110173l1.70036 -0.676394 -0.192165 -0.0764449zm-0.0342953 -0.157693c0.0194567,-0.00934646 0.0426024,-0.0108465 0.0642362,-0.00224016l-0.000122047 0.00030315 0.400642 0.15937c0.022685,0.00674409 0.0421732,0.023437 0.0515984,0.0471339 0.0163307,0.0410512 -0.0037126,0.0875748 -0.0447638,0.103906l-0.00019685 -0.000271654 -1.89081 0.752157c-0.00848031,0.0043189 -0.0178819,0.00719291 -0.0279094,0.00825197l-0.000271654 -0.000185039c-0.351902,0.0371457 -0.339311,-0.280051 -0.335307,-0.329 0.00138583,-0.0448189 0.043874,-0.0797717 0.0874213,-0.0817835 0.565346,-0.220732 1.12928,-0.439394 1.69549,-0.657642z"/><path fill-rule="nonzero" d="M4.83589 3.96189c-0.0251969,-0.0360669 -0.0748701,-0.0448819 -0.110937,-0.019685 -0.0360669,0.0251969 -0.0448819,0.0748701 -0.019685,0.110937 0.0565906,0.0809409 0.141154,0.186106 0.250461,0.277929 0.112209,0.0942598 0.250555,0.175075 0.412539,0.20435 0.0186654,0.00526772 0.133244,0.0449882 0.107437,0.22065l-9.44882e-005 -1.5748e-005c-0.000814961,0.00554724 -0.00103937,0.0110472 -0.000720472,0.016437l-0.00758661 0.280776c-0.0010315,0.0440079 0.0338071,0.0805315 0.077815,0.081563 0.0440079,0.0010315 0.0805315,-0.0338071 0.081563,-0.077815l0.00759843 -0.281173c0.0428661,-0.303622 -0.182976,-0.382783 -0.22548,-0.394909 -0.00351181,-0.00114567 -0.00714567,-0.00207087 -0.0108858,-0.00274016l0 3.93701e-006c-0.131429,-0.0234685 -0.245831,-0.0907913 -0.339681,-0.16963 -0.0971024,-0.0815709 -0.172146,-0.174882 -0.222343,-0.246677z"/><path fill-rule="nonzero" d="M1.32038 3.33617l4.26657 1.64457 9.44882e-005 -0.000244094c0.0309528,0.0119331 0.050248,0.0410118 0.0512126,0.0722126 0.00400394,0.0489449 0.0166024,0.366146 -0.335307,0.329l0.00812598 -0.079374 -0.00839764 0.0795591c-0.0100276,-0.00105906 -0.0194291,-0.00393307 -0.0279094,-0.00825197l-3.69571 -1.47013 -3.93701e-005 0.00011811c-0.00129528,-0.000425197 -0.448831,-0.14328 -0.373516,-0.464992l0 -0.0304528c0,-0.0441811 0.0358189,-0.08 0.08,-0.08 0.0125039,0 0.0243346,0.00287402 0.034878,0.00798819zm4.15747 1.77343l-4.1199 -1.58804c0.0154252,0.139894 0.242114,0.220413 0.268528,0.229343 0.00238583,0.00069685 0.00475984,0.00151181 0.00711417,0.00244882l-0.000122047 0.00030315 3.69578 1.47016c0.112669,0.00767717 0.141819,-0.0642874 0.148598,-0.114217z"/><path fill-rule="nonzero" d="M2.1214 4.05315c.0251969-.0360669.0163819-.0857402-.019685-.110937-.0360669-.0251969-.0857402-.0163819-.110937.019685-.0501969.0717953-.12524.165106-.222343.246677-.0938504.0788386-.208252.146161-.339681.16963l0-.00000393701c-.00374016.000669291-.00737402.00159449-.0108858.00274016-.0425039.012126-.268346.0912874-.22548.394909l.00759843.281173c.0010315.0440079.0375551.0788465.081563.077815.0440079-.0010315.0788465-.0375551.077815-.081563l-.00758661-.280776c.000318898-.00538976.0000944882-.0108898-.000720472-.016437l-.0000944882.000015748c-.0258071-.175661.0887717-.215382.107437-.22065.161984-.0292756.300331-.110091.412539-.20435.109307-.0918228.19387-.196988.250461-.277929zM3.3334 3.95773c0 .0440079.0356811.079689.079689.079689.0440079 0 .079689-.0356811.079689-.079689l.000240157-1.62592c0-.0440079-.0356811-.079689-.079689-.079689-.0440079 0-.079689.0356811-.079689.079689l-.000240157 1.62592zM.934996 5.22456c-.0441811 0-.08.0358189-.08.08 0 .0441811.0358189.08.08.08l4.95667 0c.0441811 0 .08-.0358189.08-.08 0-.0441811-.0358189-.08-.08-.08l-4.95667 0z"/><rect width="6.827" height="6.827" fill="none"/></svg>`,
            title: 'Ayat',
        };
    }

    /**
     * Empty Ayat is not empty Block
     *
     * @public
     * @returns {boolean}
     */
    static get contentless() {
        return true;
    }

    /**
     * Allow to press Enter inside the Ayat
     *
     * @public
     * @returns {boolean}
     */
    static get enableLineBreaks() {
        return true;
    }

    /**
     * Default placeholder for quote text
     *
     * @public
     * @returns {string}
     */
    static get DEFAULT_AYAT_TEXT_PLACEHOLDER() {
        return 'أدخل نص آيات';
    }

    /**
     * Default placeholder for quote caption
     *
     * @public
     * @returns {string}
     */
    static get DEFAULT_AYAT_TEXT_NO_DIACRITIC_PLACEHOLDER() {
        return 'ادخل نص الايه بدون شكل';
    }

    /**
     * Allowed quote alignments
     *
     * @public
     * @returns {{left: string, center: string}}
     */
    static get ALIGNMENTS() {
        return {
            left: 'left',
            center: 'center',
        };
    }

    /**
     * Default quote alignment
     *
     * @public
     * @returns {string}
     */
    static get DEFAULT_ALIGNMENT() {
        return Ayat.ALIGNMENTS.left;
    }

    /**
     * Allow Ayat to be converted to/from other blocks
     */
    static get conversionConfig() {
        return {
            /**
             * To create Ayat data from string, simple fill 'text' property
             */
            import: 'text',
            /**
             * To create string from Ayat data, concatenate text and caption
             *
             * @param {AyatData} ayatData
             * @returns {string}
             */
            export: function (ayatData) {
                return ayatData.ayatTextNoDiacritic ? `${ayatData.ayatText} — ${ayatData.ayatTextNoDiacritic}` : ayatData.ayatText;
            },
        };
    }

    /**
     * Tool`s styles
     *
     * @returns {{baseClass: string, wrapper: string, quote: string, input: string, caption: string, settingsButton: string, settingsButtonActive: string}}
     */
    get CSS() {
        return {
            baseClass: this.api.styles.block,
            wrapper: 'cdx-quote',
            text: 'cdx-quote__text',
            text_no_diacritic: 'cdx-quote__text_no_diacritic',
            input: this.api.styles.input,
            caption: 'cdx-quote__caption',
            settingsWrapper: 'cdx-quote-settings',
            settingsButton: this.api.styles.settingsButton,
            settingsButtonActive: this.api.styles.settingsButtonActive,
        };
    }

    /**
     * Tool`s settings properties
     *
     * @returns {*[]}
     */
    get settings() {
        return [
            {
                name: 'left',
                icon: `<svg width="16" height="11" viewBox="0 0 16 11" xmlns="http://www.w3.org/2000/svg" ><path d="M1.069 0H13.33a1.069 1.069 0 0 1 0 2.138H1.07a1.069 1.069 0 1 1 0-2.138zm0 4.275H9.03a1.069 1.069 0 1 1 0 2.137H1.07a1.069 1.069 0 1 1 0-2.137zm0 4.275h9.812a1.069 1.069 0 0 1 0 2.137H1.07a1.069 1.069 0 0 1 0-2.137z" /></svg>`,
            },
            {
                name: 'center',
                icon: `<svg width="16" height="11" viewBox="0 0 16 11" xmlns="http://www.w3.org/2000/svg" ><path d="M1.069 0H13.33a1.069 1.069 0 0 1 0 2.138H1.07a1.069 1.069 0 1 1 0-2.138zm3.15 4.275h5.962a1.069 1.069 0 0 1 0 2.137H4.22a1.069 1.069 0 1 1 0-2.137zM1.069 8.55H13.33a1.069 1.069 0 0 1 0 2.137H1.07a1.069 1.069 0 0 1 0-2.137z"/></svg>`,
            },
        ];
    }

    /**
     * Render plugin`s main Element and fill it with saved data
     *
     * @param {{data: AyatData, config: AyatConfig, api: object}}
     *   data — previously saved data
     *   config - user config for Tool
     *   api - Editor.js API
     *   readOnly - read-only mode flag
     */
    constructor({ data, config, api, readOnly}) {
        const { ALIGNMENTS, DEFAULT_ALIGNMENT } = Ayat;

        this.api = api;
        this.readOnly = readOnly;

        this.ayatTextPlaceholder = config.ayatTextPlaceholder || Ayat.DEFAULT_AYAT_TEXT_PLACEHOLDER;
        this.ayatTextNoDiacriticPlaceholder = config.ayatTextNoDiacriticPlaceholder || Ayat.DEFAULT_AYAT_TEXT_NO_DIACRITIC_PLACEHOLDER;

        this.data = {
            ayatText: data.ayatText || '',
            ayatTextNoDiacritic: data.ayatTextNoDiacritic || '',
            alignment: Object.values(ALIGNMENTS).includes(data.alignment) && data.alignment ||
                config.defaultAlignment ||
                DEFAULT_ALIGNMENT,
        };
    }

    /**
     * Create Ayat Tool container with inputs
     *
     * @returns {Element}
     */
    render() {
        const container = this._make('blockquote', [this.CSS.baseClass, this.CSS.wrapper]);
        const ayatText = this._make('div', [this.CSS.input, this.CSS.text], {
            contentEditable: !this.readOnly,
            innerHTML: this.data.ayatText,
        });
        const ayatTextNoDiacritic = this._make('div', [this.CSS.input, this.CSS.text_no_diacritic], {
            contentEditable: !this.readOnly,
            innerHTML: this.data.ayatTextNoDiacritic,
        })

        ayatText.dataset.placeholder = this.ayatTextPlaceholder;
        ayatTextNoDiacritic.dataset.placeholder = this.ayatTextNoDiacriticPlaceholder;

        container.appendChild(ayatText);
        container.appendChild(ayatTextNoDiacritic);

        return container;
    }

    /**
     * Extract Ayat data from Ayat Tool element
     *
     * @param {HTMLDivElement} quoteElement - element to save
     * @returns {AyatData}
     */
    save(quoteElement) {
        const ayatText = quoteElement.querySelector(`.${this.CSS.text}`);
        const ayatTextNoDiacritic = quoteElement.querySelector(`.${this.CSS.text_no_diacritic}`);

        console.log(ayatText)
        return Object.assign(this.data, {
            ayatText: ayatText.innerHTML,
            ayatTextNoDiacritic: ayatTextNoDiacritic.innerHTML,
        });
    }

    /**
     * Sanitizer rules
     */
    static get sanitize() {
        return {
            ayatText: {
                br: true,
            },
            ayatTextNoDiacritic: {
                br: true,
            },
            alignment: {},
        };
    }

    /**
     * Create wrapper for Tool`s settings buttons:
     * 1. Left alignment
     * 2. Center alignment
     *
     * @returns {HTMLDivElement}
     */
    renderSettings() {
        const wrapper = this._make('div', [ this.CSS.settingsWrapper ], {});
        const capitalize = str => str[0].toUpperCase() + str.substr(1);

        this.settings
            .map(tune => {
                const el = this._make('div', this.CSS.settingsButton, {
                    innerHTML: tune.icon,
                    title: `${capitalize(tune.name)} alignment`,
                });

                el.classList.toggle(this.CSS.settingsButtonActive, tune.name === this.data.alignment);

                wrapper.appendChild(el);

                return el;
            })
            .forEach((element, index, elements) => {
                element.addEventListener('click', () => {
                    this._toggleTune(this.settings[index].name);

                    elements.forEach((el, i) => {
                        const { name } = this.settings[i];

                        el.classList.toggle(this.CSS.settingsButtonActive, name === this.data.alignment);
                    });
                });
            });

        return wrapper;
    };

    /**
     * Toggle quote`s alignment
     *
     * @param {string} tune - alignment
     * @private
     */
    _toggleTune(tune) {
        this.data.alignment = tune;
    }

    /**
     * Helper for making Elements with attributes
     *
     * @param  {string} tagName           - new Element tag name
     * @param  {Array|string} classNames  - list or name of CSS classname(s)
     * @param  {object} attributes        - any attributes
     * @returns {Element}
     */
    _make(tagName, classNames = null, attributes = {}) {
        const el = document.createElement(tagName);

        if (Array.isArray(classNames)) {
            el.classList.add(...classNames);
        } else if (classNames) {
            el.classList.add(classNames);
        }

        for (const attrName in attributes) {
            el[attrName] = attributes[attrName];
        }

        return el;
    }
}

module.exports = Ayat;
