// market.js

window.onload = function() {
  const userJSON = localStorage.getItem('currentUser');
  if(!userJSON) {
    window.location.href = 'login.html';
    return;
  }

  // Satın al butonları için event listener
  document.querySelectorAll('.buy-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const productId = btn.getAttribute('data-id');
      const productName = btn.getAttribute('data-name');
      const productPrice = btn.getAttribute('data-price');
      openPurchaseModal(productId, productName, productPrice);
    });
  });
};

// Modal açma fonksiyonu (örnek basit)
function openPurchaseModal(id, name, price) {
  const modal = document.getElementById('purchase-modal');
  modal.style.display = 'block';

  modal.querySelector('#modal-product-name').textContent = name;
  modal.querySelector('#modal-product-price').textContent = price + " ₺";

  // Satın al formunu sıfırla
  document.getElementById('purchase-form').reset();

  // Siparişi onaylama butonu event listener
  document.getElementById('purchase-confirm-btn').onclick = function() {
    const iban = document.getElementById('iban-input').value.trim();
    const email = document.getElementById('email-input').value.trim();
    const receipt = document.getElementById('receipt-input').files[0];

    if(!iban || !email || !receipt) {
      alert('Lütfen tüm bilgileri doldurun ve dekont yükleyin.');
      return;
    }

    // Siparişi kaydet (localStorage veya başka yerde)
    saveOrder({ id, name, price, iban, email, receiptName: receipt.name, date: new Date().toISOString() });

    alert('Siparişiniz alındı. Teşekkürler!');
    modal.style.display = 'none';
  };

  // Kapat butonu
  document.getElementById('purchase-cancel-btn').onclick = function() {
    modal.style.display = 'none';
  };
}

// Siparişleri localStorage'da saklayacağız (örnek)
function saveOrder(order) {
  let orders = JSON.parse(localStorage.getItem('orders')) || [];
  orders.push(order);
  localStorage.setItem('orders', JSON.stringify(orders));
}
