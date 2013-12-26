var app = app || {};

(function() {
	'use strict';

	// Todo Model
	// ----------

	// Our basic **Todo** model has `title`, `order`, and `completed` attributes.
	app.Todo = Backbone.Model.extend({

		// Default attributes for the todo
		// and ensure that each todo created has `title` and `completed` keys.
		defaults: {
			title: '',
			completed: false
		},
		
		urlRoot: "slimsv/todos",  

		// Toggle the `completed` state of this todo item.
		toggle: function() {
            console.log(this.get('completed'));
			this.save({
				completed: !this.get('completed'),
                title: this.get('title')
			});
		}

	});

}());
