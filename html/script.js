document.addEventListener("DOMContentLoaded", () => {
  console.log("Website TKJ Siap! 🚀");

  // Efek muncul saat scroll
  const fadeElements = document.querySelectorAll(".fade-in");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
      }
    });
  }, { threshold: 0.3 });

  fadeElements.forEach(el => observer.observe(el));

  // Pop-up modal
  const modal = document.getElementById("modal");
  const modalImg = document.getElementById("modal-img");
  const modalNama = document.getElementById("modal-nama");
  const modalKelas = document.getElementById("modal-kelas");
  const modalKeahlian = document.getElementById("modal-keahlian");
  const modalDeskripsi = document.getElementById("modal-deskripsi");
  const closeBtn = document.querySelector(".close-btn");

  // Klik gambar untuk buka modal
  document.querySelectorAll(".card img").forEach(img => {
    img.addEventListener("click", (e) => {
      const parent = e.target.closest(".card");
      modal.style.display = "flex";
      modalImg.src = e.target.src;
      modalNama.textContent = parent.dataset.nama;
      modalKelas.textContent = parent.dataset.kelas;
      modalKeahlian.textContent = parent.dataset.keahlian;
      modalDeskripsi.textContent = parent.dataset.deskripsi;
    });
  });

  // Tutup modal
  closeBtn.addEventListener("click", () => modal.style.display = "none");
  modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });
});
