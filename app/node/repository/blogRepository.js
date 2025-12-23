const db = require("../config/db");
const findAll = () => {
    return new Promise((resolve, reject) => {
        db.query("SELECT * FROM blog_posts", (err, result) => {
            if (err) reject(err);
            resolve(result);
        });
    });
};
const findById = (id) => {
    return new Promise((resolve, reject) => {
        db.query(
            "SELECT * FROM blog_posts WHERE id = ?",
            [id],
            (err, result) => {
                if (err) reject(err);
                resolve(result[0]);
            }
        );
    });
};
// const create = (data) => {
//     return new Promise((resolve, reject) => {
//         db.query("INSERT INTO blog_posts SET ?", data, (err, result) => {
//             if (err) reject(err);
//             resolve(result);
//         });
//     });
// };
const update = (id, data) => {
    return new Promise((resolve, reject) => {
        db.query(
            "UPDATE blog_posts SET ? WHERE id = ?",
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
        db.query("DELETE FROM blog_posts WHERE id = ?", [id], (err, result) => {
            if (err) reject(err);
            resolve(result);
        });
    });
};
module.exports = {
    findAll,
    findById,
    // create,
    update,
    destroy,
};
