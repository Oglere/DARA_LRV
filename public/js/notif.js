document.querySelectorAll(".filter-btn").forEach((button) => {
    button.addEventListener("click", () => {
      const role = button.getAttribute("data-role");
  
      document.querySelectorAll(".filter-btn").forEach((btn) => {
        btn.classList.replace("btn-primary", "btn-secondary");
      });
      button.classList.replace("btn-secondary", "btn-primary");
  
      filterStudies(role);
    });
  });
  
  document.getElementById("search-bar").addEventListener("input", () => {
    const activeBtn = document.querySelector(".filter-btn.btn-primary");
    const role = activeBtn ? activeBtn.getAttribute("data-role") : "all";
    filterStudies(role);
  });
  
  function filterStudies(status = "all") {
    const query = document.getElementById("search-bar").value.toLowerCase();
    const studies = document.querySelectorAll(".nb");
  
    studies.forEach((study) => {
      const name = study.querySelector(".chn")?.textContent.toLowerCase() || "";
      const title = study.querySelector(".cb a")?.textContent.toLowerCase() || "";
      const currentStatus = study.querySelector(".status")?.textContent || "";
  
      const matchesSearch = name.includes(query) || title.includes(query);
      const matchesStatus = status === "all" || currentStatus === status;
  
      study.style.display = matchesSearch && matchesStatus ? "block" : "none";
    });
  }
  