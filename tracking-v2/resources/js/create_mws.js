document.addEventListener("DOMContentLoaded", function () {
  function showNotification(message, type = "success") {
    const existing = document.getElementById("toast-notification");
    if (existing) existing.remove();
    const styles = { success: "bg-green-500", error: "bg-red-600" };
    const div = document.createElement("div");
    div.id = "toast-notification";
    div.className = `fixed top-5 right-5 text-white px-4 py-3 rounded-xl shadow-xl ${styles[type]} z-50`;
    div.textContent = message;
    document.body.appendChild(div);
    setTimeout(() => div.remove(), 4000);
  }

  async function fetchJobTypes() {
    const res = await fetch("/api/get_job_types");
    const data = await res.json();
    const list = document.getElementById("jobTypeList");
    const input = document.getElementById("jobTypeSearch");
    if (data.success) {
      input.disabled = false;
      list.innerHTML = "";
      data.job_types.forEach((jt) => {
        const li = document.createElement("li");
        li.textContent = jt;
        li.className = "px-4 py-2 hover:bg-blue-50 cursor-pointer";
        li.onclick = () => {
          input.value = jt;
          document.getElementById("jobTypeInput").value = jt;
          document.getElementById("jobTypeDropdown").classList.add("hidden");
        };
        list.appendChild(li);
      });
    }
  }

  fetchJobTypes();

  const form = document.getElementById("createMwsForm");
  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const json = Object.fromEntries(formData.entries());
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    try {
      const res = await fetch("/mws/store", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token,
        },
        body: JSON.stringify(json),
      });
      const data = await res.json();
      if (data.success) {
        showNotification("MWS berhasil dibuat!");
        setTimeout(() => (window.location.href = `/mws/${data.id}`), 1000);
      } else {
        showNotification("Gagal menyimpan data", "error");
      }
    } catch (err) {
      console.error(err);
      showNotification("Tidak dapat terhubung ke server", "error");
    }
  });
});