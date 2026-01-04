const express = require("express");
const cors = require("cors");
const app = express();
const productRoutes = require("./routes/productRoutes");
const blogRoutes = require("./routes/blogRoutes");
const donationUpdates = require("./routes/donationUpdates");

app.use(cors());
app.use(express.json());

app.use("/products", productRoutes);
app.use("/blogs", blogRoutes);
app.use("/donation-updates", donationUpdates);

app.get('/', (req, res) => {
    res.send('Node API ReTide running');
});

app.listen(3000, () => {
    console.log("Server running on port 3000");
});
