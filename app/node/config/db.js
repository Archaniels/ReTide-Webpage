const mysql = require("mysql");
// require("dotenv").config();
const db = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "",
    database: "retide",
});
db.connect((err) => {
    if (err) throw err;
    console.log("Database is now connected!");
});
module.exports = db;
