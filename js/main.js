// main.js

window.onload = function() {
  const userJSON = localStorage.getItem('currentUser');
  if(!userJSON) {
    // Kullanıcı giriş yapmamış, login sayfasına yönlendir
    window.location.href = 'login.html';
    return;
  }
  const user = JSON.parse(userJSON);

  // Kullanıcı adını göster
  document.getElementById('username-display').textContent = user.username;

  // Yönetici butonunu göster veya gizle
  const adminBtn = document.getElementById('admin-btn');
  if(user.isAdmin) {
    adminBtn.style.display = 'inline-block';
  } else {
    adminBtn.style.display = 'none';
  }

  // Çıkış butonu
  document.getElementById('logout-btn').addEventListener('click', () => {
    localStorage.removeItem('currentUser');
    window.location.href = 'login.html';
  });
};
