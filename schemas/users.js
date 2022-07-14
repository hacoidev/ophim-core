const mongoose = require("mongoose");
const databaseConfig = require(__path_configs + "database");

var schema = new mongoose.Schema({
	fullname: String,
	user_name: String,
	password: String,
	group_acp: {
		id: Number,
		name: String,
	},
	created: {
		user_id: Number,
		user_name: String,
		time: Date,
	},
	modified: {
		user_id: Number,
		user_name: String,
		time: Date,
	},
});

module.exports = mongoose.model(databaseConfig.col_users, schema);
