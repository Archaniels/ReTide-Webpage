const db = require("../config/db");
const findAll = () => {
    return new Promise((resolve, reject) => {
        db.query("SELECT * FROM marketplace_products", (err, result) => {
            if (err) reject(err);
            resolve(result);
        });
    });
};
const findById = (id) => {
    return new Promise((resolve, reject) => {
        db.query(
            "SELECT * FROM marketplace_products WHERE id = ?",
            [id],
            (err, result) => {
                if (err) reject(err);
                resolve(result[0]);
            }
        );
    });
};
const create = (data) => {
    return new Promise((resolve, reject) => {
        db.query(
            "INSERT INTO marketplace_products SET ?",
            data,
            (err, result) => {
                if (err) reject(err);
                resolve(result);
            }
        );
    });
};
const update = (id, data) => {
    return new Promise((resolve, reject) => {
        db.query(
            "UPDATE marketplace_products SET ? WHERE id = ?",
            [data, id],
            (err, result) => {
                if (err) reject(err);
                resolve(result);
            }
        );
    });
};
const destroy = (id) => {
    return new Promise((resolve, reject) => {
        db.query(
            "DELETE FROM marketplace_products WHERE id = ?",
            [id],
            (err, result) => {
                if (err) reject(err);
                resolve(result);
            }
        );
    });
};
module.exports = { findAll, findById, create, update, destroy };
