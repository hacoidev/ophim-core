const mongoose = require("mongoose");
const databaseConfig = require(__path_configs + "database");

var schema = new mongoose.Schema({
	name: String,
	origin_name: String,
	content: String,
	type: String,
	status: String,
	fetch_url: String,
	fetch_ophim_id: String,
	fetch_ophim_modified: String,
	thumb_url: String,
	is_copyright: String,
	trailer_url: String,
	time: String,
	on_top: String,
	episode_current: String,
	episode_total: String,
	quality: String,
	lang: String,
	notify: String,
	showtimes: String,
	slug: String,
	year: Number,
	view: Number,
	view_day: Number,
	view_week: Number,
	view_month: Number,
	actor: Array,
	director: Array,
	category: Array,
	country: Array,
	tags: Array,
	episode_server_count: Number,
	episode_data_count: Number,
	rating: {
		vote_count: Number,
		vote_stars: Number,
	},
	created: {
		user_id: mongoose.ObjectId,
		user_name: String,
		time: Date,
	},
	modified: {
		user_id: mongoose.ObjectId,
		user_name: String,
		time: Date,
	},
});

module.exports = mongoose.model(databaseConfig.col_movies, schema);
