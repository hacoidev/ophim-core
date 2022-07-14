const mongoose = require("mongoose");
const databaseConfig = require(__path_configs + "database");

var schema = new mongoose.Schema({
	name: String,
	slug: String,
	seo_title: String,
	seo_des: String,
	seo_key: String,
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

module.exports = mongoose.model(databaseConfig.col_country, schema);
