const express = require('express');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

const donationUpdates = require('./routes/donationUpdates');
app.use('/donation-updates', donationUpdates);

app.get('/', (req, res) => {
  res.send('Node API ReTide running');
});

app.listen(3000, () => {
  console.log('Node API running on http://localhost:3000');
});
