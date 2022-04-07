'use strict';

define(
    [
        'underscore',
        'pim/controller/front',
        'pim/form-builder',
        'pim/fetcher-registry'
    ],
    function (_, BaseController, FormBuilder, FetcherRegistry) {
        return BaseController.extend({
            initialize: function (options) {
                this.options = options;
            },

            /**
             * {@inheritdoc}
             */
            renderForm: function (route) {
                var self = this;
                return FetcherRegistry.getFetcher('custom_entity')
                    .fetchAll()
                    .then(function (items) {
                        var customEntityName = Object.keys(items)[0];

                        return FormBuilder.build('pim-' + customEntityName +'-index')
                            .then((form) => {
                                form.setElement(self.$el).render();

                                return form;
                            });
                    });
            }
        });
    }
);
