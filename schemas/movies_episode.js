const mongoose = require('mongoose');
const databaseConfig = require(__path_configs + 'database');

var schema = new mongoose.Schema({ 
    movies_id   : String,
    slug        : String,
    episode     : Array
});

module.exports = mongoose.model(databaseConfig.col_movies_episode,schema);