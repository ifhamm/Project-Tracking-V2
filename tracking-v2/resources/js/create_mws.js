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
        try {
            console.log("Menjalankan fetchJobTypes...");

            const res = await fetch("/api/get_job_types");
            const data = await res.json();

            console.log("Data dari API:", data);

            const list = document.getElementById("jobTypeList");
            const input = document.getElementById("jobTypeSearch");
            const dropdown = document.getElementById("jobTypeDropdown");

            if (!list || !input) {
                console.error(
                    "Elemen jobTypeList atau jobTypeSearch tidak ditemukan!"
                );
                return;
            }

            if (data.success && Array.isArray(data.job_types)) {
                input.disabled = false;
                list.innerHTML = "";

                data.job_types.forEach((jt) => {
                    const li = document.createElement("li");
                    li.textContent = jt;
                    li.className =
                        "px-4 py-2 hover:bg-blue-50 cursor-pointer text-gray-900";
                    li.onclick = () => {
                        input.value = jt;
                        document.getElementById("jobTypeInput").value = jt;
                        dropdown.classList.add("hidden");
                    };
                    list.appendChild(li);
                });

                dropdown.classList.remove("hidden");
            } else {
                list.innerHTML =
                    '<li class="px-4 py-2 text-gray-500 italic">Tidak ada data</li>';
            }
        } catch (error) {
            console.error("Gagal mengambil job types:", error);
        }
    }

    fetchJobTypes();

    const form = document.getElementById("createMwsForm");
    form.addEventListener("submit", async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const json = Object.fromEntries(formData.entries());
        const token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        try {
            const res = await fetch("/mws/store", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },
                body: formData,
                credentials: "same-origin",
            });

            if (!res.ok) throw new Error(`HTTP Error: ${res.status}`);

            const data = await res.json();
            if (data.success) {
                showNotification("MWS berhasil dibuat!");
                setTimeout(
                    () => (window.location.href = `/mws/${data.id}/steps`),
                    1000
                );
            } else {
                showNotification("Gagal menyimpan data", "error");
            }
        } catch (err) {
            console.error(err);
            showNotification("Tidak dapat terhubung ke server", "error");
        }
    });
});
