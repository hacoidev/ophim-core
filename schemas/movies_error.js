const mongoose = require('mongoose');
const databaseConfig = require(__path_configs + 'database');

var schema = new mongoose.Schema({
    name              : String,
    slug              : String,
    episode_slug      : String,
    server_id         : Number,
    message           : String,
    created: {
			time            : Date
    },
    modified: {
			time            : Date
    }
});

module.exports = mongoose.model(databaseConfig.col_movies_error,schema);
