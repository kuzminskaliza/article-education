// jshint esversion: 6

$(document).ready(function () {
    'use strict'
    let tagForm = {

        addTagButtonSelector: '#addTag',
        tagContainerSelector: '#tag-container',
        tagInputSelector: '.tag-input',
        removeTagButtonSelector: '.remove-tag',

        init: function () {
            console.log('init');
            this.initListenerOnAddTag();
            this.initListenerOnRemoveTag();
            this.removeButtons();
        },

        tagTemplate: function (index) {
            return `
                <div class="input-group mb-3 tag-input">
                    <input type="text" name="tags[${index}]" class="form-control">
                    <div class="input-group-append">
                        <span class="input-group-text remove-tag"><i class="fas fa-times"></i></span>
                    </div>
                </div>
            `;
        },

        initListenerOnAddTag: function () {
            let $this = this;
            $(this.addTagButtonSelector).on('click', function () {
                $this.addTag();
            });
        },

        addTag: function () {
            let maxIndex = this.getMaxIndex() + 1;
            let newTagInput = this.tagTemplate(maxIndex);
            $(this.tagContainerSelector).append(newTagInput);
            this.removeButtons();
        },

        getMaxIndex: function () {
            let maxIndex = 0;
            $(this.tagInputSelector).each(function () {
                let match = $(this).find('input').attr('name').match(/\d+/);
                if (match) {
                    maxIndex = Math.max(maxIndex, parseInt(match[0], 10));
                }
            });
            return maxIndex;
        },

        initListenerOnRemoveTag: function () {
            let $this = this;
            $(document).on('click', this.removeTagButtonSelector, function () {
                $this.removeTag($(this));
            });
        },

        removeTag: function ($button) {
            if ($(this.tagInputSelector).length > 1) {
                $button.closest('.tag-input').remove();
            }
            this.removeButtons();
        },

        removeButtons: function () {
            let inputs = $(this.tagInputSelector);
            let removeButtons = $(this.removeTagButtonSelector);

            if (inputs.length > 1) {
                removeButtons.show();
            } else {
                removeButtons.hide();
            }
        }
    };
    tagForm.init();
});
