const express = require("express");
const app = express();
const productRoutes = require("./routes/productRoutes");
const blogRoutes = require("./routes/blogRoutes");
app.use(express.json());
app.use("/products", productRoutes);
app.use("/blogs", blogRoutes);
app.listen(3000, () => {
    console.log("Server running on port 3000");
});
