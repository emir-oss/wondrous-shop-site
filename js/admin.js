// admin.js

window.onload = function() {
  const userJSON = localStorage.getItem('currentUser');
  if(!userJSON) {
    window.location.href = 'login.html';
    return;
  }
  const user = JSON.parse(userJSON);
  if(!user.isAdmin) {
    alert('Bu sayfaya erişim yetkiniz yok.');
    window.location.href = 'index.html';
    return;
  }

  // Siparişleri getir ve listele
  const orders = JSON.parse(localStorage.getItem('orders')) || [];
  const ordersList = document.getElementById('orders-list');

  if(orders.length === 0) {
    ordersList.innerHTML = '<p>Henüz sipariş yok.</p>';
    return;
  }

  orders.forEach((order, i) => {
    const div = document.createElement('div');
    div.className = 'order-item';
    div.innerHTML = `
      <h3>${order.name} - ${order.price} ₺</h3>
      <p><strong>İban:</strong> ${order.iban}</p>
      <p><strong>Email:</strong> ${order.email}</p>
      <p><strong>Görsel Adı:</strong> ${order.receiptName}</p>
      <p><small>${new Date(order.date).toLocaleString()}</small></p>
      <hr>
    `;
    ordersList.appendChild(div);
  });

  // Çıkış butonu
  document.getElementById('logout-btn').addEventListener('click', () => {
    localStorage.removeItem('currentUser');
    window.location.href = 'login.html';
  });
};
