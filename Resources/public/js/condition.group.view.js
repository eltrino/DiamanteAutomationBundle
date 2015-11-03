define(['underscore', 'backbone', './mock'
], function (_, Backbone, Mock) {
    'use strict';

    var $ = Backbone.$;

    return Backbone.View.extend({
        tagName: 'div',
        className: 'condition-group',
        template: _.template($('#group-condition').html()),
        viewTemplate: _.template($('#group-condition-view').html()),
        editTemplate: _.template($('#group-condition-edit').html()),

        initialize: function () {
            var that = this,
                events = {
                    'click .delete': 'removeGroup',
                    'click .save': 'saveGroup',
                    'click .edit': 'editGroup',
                    'change select': 'changeElement'
                };

            this.events = {};
            this.mock = Mock;
            this.model.view = this;

            _.each(events, function (handler, event) {
                var actionSelector = event + '.' + that.cid;
                that.events[actionSelector] = handler;
            });

            this.listenTo(this.model, 'expressionChanged', this.redrawEdit);
        },

        removeGroup: function () {
            this.collection.remove(this.model);
            this.remove();
            this.collection.trigger("toJson");
        },

        redrawEdit: function() {
            $('.edit-group', this.$el).html(this.renderEdit());
        },

        editGroup: function () {
            this.$el.children('.edit-group').html(this.renderEdit());
            this.$el.children('.edit-group, .save').removeClass('x-hide');
            this.$el.children('.view-group, .edit').addClass('x-hide');
        },

        saveGroup: function () {
            this.$el.children('.view-group').html(this.renderView());
            this.$el.children('.edit-group, .save').addClass('x-hide');
            this.$el.children('.view-group, .edit').removeClass('x-hide');
console.log(this.collection);
            this.collection.trigger("toJson");
        },

        changeElement: function (e) {
            var el = $(e.target),
                property = el.data('property'),
                value = el.val();

            this.model.set(property, value, {'silent': true}).trigger('expressionChanged');
        },

        render: function (template, container) {
            this.$el.html(this.template());
            $(container, this.$el).html(template);
            return this;
        },

        renderItemView: function () {
            return this.render(this.renderView(), '.view-group');
        },

        renderItemEdit: function () {
            var template = this.render(this.renderEdit(), '.edit-group');
            $('.edit', this.$el).addClass('x-hide');
            $('.edit-group, .save', this.$el).removeClass('x-hide');

            return template;
        },

        renderEdit: function () {
            var data = {
                'expressions': this.mock.expressions,
                'attrs': this.model.attributes
            };

            return this.editTemplate(data);
        },

        renderView: function () {
            var data = {
                'expressions': this.mock.expressions,
                'attrs': this.model.attributes
            };

            return this.viewTemplate(data);
        }
    });
});