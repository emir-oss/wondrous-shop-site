// auth.js

// Kullanıcıları localStorage'da saklayacağız (basit örnek)

function saveUser(user) {
  let users = JSON.parse(localStorage.getItem('users')) || [];
  users.push(user);
  localStorage.setItem('users', JSON.stringify(users));
}

function findUserByEmail(email) {
  let users = JSON.parse(localStorage.getItem('users')) || [];
  return users.find(u => u.email === email);
}

function registerUser(username, email, password) {
  if(findUserByEmail(email)) {
    return { success: false, message: "Bu email zaten kullanılıyor." };
  }
  const newUser = { username, email, password, isAdmin: false }; // isAdmin elle eklenecek
  saveUser(newUser);
  return { success: true };
}

function loginUser(email, password) {
  const user = findUserByEmail(email);
  if(!user) return { success: false, message: "Kullanıcı bulunamadı." };
  if(user.password !== password) return { success: false, message: "Şifre yanlış." };
  return { success: true, user };
}

// Admin hesabını manuel eklemek için (örnek)
function addAdminUser() {
  let users = JSON.parse(localStorage.getItem('users')) || [];
  const adminEmail = "admin@example.com";
  if(!users.some(u => u.email === adminEmail)) {
    users.push({ username: "Admin", email: adminEmail, password: "admin123", isAdmin: true });
    localStorage.setItem('users', JSON.stringify(users));
  }
}

// Sayfa yüklenince admin hesabı oluştur
addAdminUser();
