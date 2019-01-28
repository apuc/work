<main class="content-wrapper">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Switch</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <div class="template-demo">
                            <div class="mdc-switch">
                                <input type="checkbox" id="basic-switch" class="mdc-switch__native-control"/>
                                <div class="mdc-switch__background">
                                    <div class="mdc-switch__knob"></div>
                                </div>
                            </div>
                            <div class="mdc-switch mdc-switch--disabled">
                                <input type="checkbox" id="another-basic-switch" class="mdc-switch__native-control"
                                       disabled/>
                                <div class="mdc-switch__background">
                                    <div class="mdc-switch__knob"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Select Menu</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <div class="template-demo">
                            <div id="hero-js-select" class="mdc-select" role="listbox">
                                <div class="mdc-select__surface" tabindex="0">
                                    <div class="mdc-select__label">Pick a Food Group</div>
                                    <div class="mdc-select__selected-text"></div>
                                    <div class="mdc-select__bottom-line"></div>
                                </div>
                                <div class="mdc-simple-menu mdc-select__menu">
                                    <ul class="mdc-list mdc-simple-menu__items">
                                        <li class="mdc-list-item" role="option" tabindex="0">
                                            Bread, Cereal, Rice, and Pasta
                                        </li>
                                        <li class="mdc-list-item" role="option" tabindex="0">
                                            Vegetables
                                        </li>
                                        <li class="mdc-list-item" role="option" tabindex="0">
                                            Fruit
                                        </li>
                                        <li class="mdc-list-item" role="option" tabindex="0">
                                            Milk, Yogurt, and Cheese
                                        </li>
                                        <li class="mdc-list-item" role="option" tabindex="0">
                                            Meat, Poultry, Fish, Dry Beans, Eggs, and Nuts
                                        </li>
                                        <li class="mdc-list-item" role="option" tabindex="0">
                                            Fats, Oils, and Sweets
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Text Field</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <div class="mdc-layout-grid__inner">
                            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4-desktop">
                                <div class="template-demo">
                                    <div id="demo-tf-box-wrapper">
                                        <div id="tf-box-example" class="mdc-text-field mdc-text-field--box w-100">
                                            <input required pattern=".{8,}" type="text" id="tf-box"
                                                   class="mdc-text-field__input"
                                                   aria-controls="name-validation-message">
                                            <label for="tf-box" class="mdc-text-field__label">Your Name</label>
                                            <div class="mdc-text-field__bottom-line"></div>
                                        </div>
                                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"
                                           id="name-validation-msg">
                                            Must be at least 8 characters
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4-desktop">
                                <div class="template-demo">
                                    <div id="demo-tf-box-leading-wrapper">
                                        <div id="tf-box-leading-example"
                                             class="mdc-text-field mdc-text-field--box mdc-text-field--with-leading-icon w-100">
                                            <i class="material-icons mdc-text-field__icon" tabindex="0">event</i>
                                            <input type="text" id="tf-box-leading" class="mdc-text-field__input">
                                            <label for="tf-box-leading" class="mdc-text-field__label">Your name</label>
                                            <div class="mdc-text-field__bottom-line"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Checkbox</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <div class="template-demo">
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox">
                                    <input type="checkbox" id="basic-checkbox" class="mdc-checkbox__native-control"/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark__path" fill="none" stroke="white"
                                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                                <label for="basic-checkbox">Default</label>
                            </div>
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox mdc-checkbox--disabled">
                                    <input type="checkbox" id="basic-disabled-checkbox"
                                           class="mdc-checkbox__native-control" disabled/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark__path" fill="none" stroke="white"
                                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                                <label for="basic-disabled-checkbox">Disabled</label>
                            </div>
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox">
                                    <input type="checkbox" id="basic-indeterminate-checkbox"
                                           class="mdc-checkbox__native-control"/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark__path" fill="none" stroke="white"
                                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                                <label for="basic-indeterminate-checkbox">Indeterminate</label>
                            </div>
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox demo-checkbox--custom-all">
                                    <input type="checkbox" id="basic-custom-checkbox-all"
                                           class="mdc-checkbox__native-control"/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark__path" dropzone="" fill="none"
                                                  stroke="white" d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                                <label for="basic-custom-checkbox-all">Custom colored</label>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                <div class="mdc-card">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">Radio</h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        <div class="template-demo">
                            <div class="mdc-form-field">
                                <div class="mdc-radio" data-mdc-auto-init="MDCRipple">
                                    <input class="mdc-radio__native-control" type="radio" id="ex0-default-radio1"
                                           checked name="ex0-default">
                                    <div class="mdc-radio__background">
                                        <div class="mdc-radio__outer-circle"></div>
                                        <div class="mdc-radio__inner-circle"></div>
                                    </div>
                                </div>
                                <label id="ex0-default-radio1-label" for="ex0-default-radio1">Default Radio 1</label>
                            </div>
                            <div class="mdc-form-field">
                                <div class="mdc-radio" data-mdc-auto-init="MDCRipple">
                                    <input class="mdc-radio__native-control" type="radio" id="ex0-default-radio2"
                                           name="ex0-default">
                                    <div class="mdc-radio__background">
                                        <div class="mdc-radio__outer-circle"></div>
                                        <div class="mdc-radio__inner-circle"></div>
                                    </div>
                                </div>
                                <label id="ex0-default-radio2-label" for="ex0-default-radio2">Default Radio 2</label>
                            </div>
                            <div class="mdc-form-field">
                                <div class="mdc-radio demo-radio--custom">
                                    <input class="mdc-radio__native-control" type="radio" id="ex1-custom-radio1" checked
                                           name="ex1-custom">
                                    <div class="mdc-radio__background">
                                        <div class="mdc-radio__outer-circle"></div>
                                        <div class="mdc-radio__inner-circle"></div>
                                    </div>
                                </div>
                                <label id="ex1-custom-radio1-label" for="ex1-custom-radio1">Custom Radio 1</label>
                            </div>
                            <div class="mdc-form-field">
                                <div class="mdc-radio demo-radio--custom">
                                    <input class="mdc-radio__native-control" type="radio" id="ex1-custom-radio2"
                                           name="ex1-custom">
                                    <div class="mdc-radio__background">
                                        <div class="mdc-radio__outer-circle"></div>
                                        <div class="mdc-radio__inner-circle"></div>
                                    </div>
                                </div>
                                <label id="ex1-custom-radio2-label" for="ex1-custom-radio2">Custom Radio 2</label>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>