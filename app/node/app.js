const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Routes
app.get('/', (req, res) => {
  res.json({ message: 'ReTide Node.js API is running', endpoints: ['/donation-updates'] });
});

app.use('/donation-updates', require('./routes/donationUpdates'));

// Start server
app.listen(PORT, () => {
  console.log(`Node.js API running on http://localhost:${PORT}`);
}).on('error', (err) => {
  console.error('Server error:', err);
});