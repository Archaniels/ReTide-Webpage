const axios = require('axios');

// Test API
const BASE_URL = 'http://localhost:3000';

async function test() {
  try {
    console.log('Testing Node.js API...\n');
    
    // 1. Get all updates
    console.log('1. Fetching all updates...');
    let response = await axios.get(`${BASE_URL}/donation-updates`);
    console.log('All updates:', response.data);
    console.log('');

    // 2. Create update for donation ID 1
    console.log('2. Creating update for donation ID 1...');
    response = await axios.post(`${BASE_URL}/donation-updates`, {
      donation_id: 1,
      title: 'Donasi Diterima',
      description: 'Terima kasih telah berdonasi! Donasi Anda telah kami terima dengan baik.',
      status: 'completed'
    });
    console.log('Created update:', response.data);
    console.log('');

    // 3. Create another update
    console.log('3. Creating another update for donation ID 1...');
    response = await axios.post(`${BASE_URL}/donation-updates`, {
      donation_id: 1,
      title: 'Sedang Diproses',
      description: 'Donasi Anda sedang diverifikasi oleh tim kami.',
      status: 'in_progress'
    });
    console.log('Created update:', response.data);
    console.log('');

    // 4. Get updates for donation ID 1
    console.log('4. Fetching updates for donation ID 1...');
    response = await axios.get(`${BASE_URL}/donation-updates/1`);
    console.log('Updates for donation 1:', response.data);
    console.log('');

    // 5. Create update for donation ID 2
    console.log('5. Creating update for donation ID 2...');
    response = await axios.post(`${BASE_URL}/donation-updates`, {
      donation_id: 2,
      title: 'Terima Kasih',
      description: 'Donasi besar Anda sangat membantu program kami.',
      status: 'completed'
    });
    console.log('Created update:', response.data);
    console.log('');

    // 6. Get updates for donation ID 2
    console.log('6. Fetching updates for donation ID 2...');
    response = await axios.get(`${BASE_URL}/donation-updates/2`);
    console.log('Updates for donation 2:', response.data);
    console.log('');

    console.log('✅ All tests completed successfully!');

  } catch (error) {
    console.error('Error:', error.message);
    if (error.response) {
      console.error('Response data:', error.response.data);
    }
  }
}

test();
