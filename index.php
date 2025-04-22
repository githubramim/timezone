<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Live Time Comparison</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Agbalumo&display=swap');
    body {
      transition: background 0.5s, color 0.5s;
      min-height: 100vh;
      padding: 40px;
      font-family: "Agbalumo", system-ui;
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
      transition: background 0.5s, color 0.5s;
    }

    .time-box {
      font-size: 1.2rem;
      padding: 10px;
      border-radius: 10px;
      transition: background 0.5s, color 0.5s;
    }

    .daytime {
      background-color: #e0f7fa;
      color: #00796b;
    }

    .nighttime {
      background-color: #263238;
      color: #ffffff;
    }

    .dark-mode {
      background: #121212;
      color: #e0e0e0;
    }

    .dark-mode .card {
      background: #1e1e1e;
      color: #f5f5f5;
    }

    .dark-mode .form-control {
      background-color: #2e2e2e;
      color: #f5f5f5;
      border: 1px solid #555;
    }

    .dark-mode .form-control::placeholder {
      color: #ccc;
    }

    .mode-toggle {
      position: fixed;
      top: 20px;
      right: 30px;
      z-index: 1000;
    }
  </style>
</head>
<body id="main-body" class="light-mode">
<div class="d-flex gap-3 justify-content-center my-4">
  <a href="https://github.com/githubramim" target="_blank" class="btn btn-dark rounded-circle">
    <i class="fab fa-github"></i>
  </a>
  <a href="https://www.youtube.com/@TanvirBinFarukRamimYT" target="_blank" class="btn btn-danger rounded-circle">
    <i class="fab fa-youtube"></i>
  </a>
  <a href="https://linkedin.com/in/ramimhere" target="_blank" class="btn btn-primary rounded-circle">
    <i class="fab fa-linkedin-in"></i>
  </a>
  <a href="https://www.instagram.com/tanvirbinfarukramim/" target="_blank" class="btn btn-gradient rounded-circle" style="background: radial-gradient(circle at 30% 30%, #feda75, #d62976, #962fbf, #4f5bd5); color: white;">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="https://facebook.com/TanvirRamimDM" target="_blank" class="btn btn-primary rounded-circle">
    <i class="fab fa-facebook-f"></i>
  </a>
    <a href="https://twitter.com/TanvirRamim" target="_blank" class="btn btn-info rounded-circle">
        <i class="fab fa-twitter"></i>  
    </a>
</div>


  <div class="mode-toggle form-check form-switch">
    <input class="form-check-input" type="checkbox" id="toggleMode" onchange="toggleTheme()">
    <label class="form-check-label text-white" for="toggleMode">🌙</label>
  </div>

  <div class="container">
    <div class="text-center mb-5">
      <h1 class="fw-bold text-info">🌍 Live City Time Comparison</h1>
      <p class="text-danger">Real-time time & difference between two cities or countries</p>
    </div>

    <div class="card p-4">
      <div class="row g-3">
        <div class="col-md-5">
          <input list="zones" id="zone1" class="form-control form-control-lg" placeholder="City or Timezone 1">
        </div>
        <div class="col-md-5">
          <input list="zones" id="zone2" class="form-control form-control-lg" placeholder="City or Timezone 2">
        </div>
        <div class="col-md-2 d-grid">
          <button onclick="startLiveUpdate()" class="btn btn-primary btn-lg">Compare</button>
        </div>
      </div>

      <datalist id="zones">
        <?php
          foreach (DateTimeZone::listIdentifiers() as $zone) {
            echo "<option value=\"$zone\">";
          }
        ?>
      </datalist>

      <div id="result" class="mt-4 row text-center g-4">
        <!-- Live time output will appear here -->
      </div>
    </div>
  </div>

  <h1><marquee behavior="" direction="">Developed By Ramim </marquee></h1>

<script>
  let intervalId;

  function getTimeClass(hour) {
    return (hour >= 6 && hour < 18) ? "daytime" : "nighttime";
  }

  function startLiveUpdate() {
    const zone1 = document.getElementById("zone1").value;
    const zone2 = document.getElementById("zone2").value;

    if (!zone1 || !zone2) {
      alert("Please select both cities!");
      return;
    }

    if (intervalId) clearInterval(intervalId);

    intervalId = setInterval(() => {
      fetch(`get_time.php?zone1=${zone1}&zone2=${zone2}`)
        .then(res => res.json())
        .then(data => {
          if (data.error) {
            document.getElementById("result").innerHTML = `<div class="text-danger">${data.error}</div>`;
            clearInterval(intervalId);
          } else {
            const hour1 = new Date(data.time1).getHours();
            const hour2 = new Date(data.time2).getHours();

            const class1 = getTimeClass(hour1);
            const class2 = getTimeClass(hour2);

            document.getElementById("result").innerHTML = `
              <div class="col-md-4 offset-md-2">
                <div class="time-box ${class1}">
                  <h5>${zone1}</h5>
                  <div>${data.time1}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="time-box ${class2}">
                  <h5>${zone2}</h5>
                  <div>${data.time2}</div>
                </div>
              </div>
              <div class="col-12 mt-4">
                <div class="alert alert-info fw-bold">
                  🕐 সময়ের পার্থক্য: ${data.difference}
                </div>
              </div>
            `;
          }
        });
    }, 1000);
  }

  function toggleTheme() {
    const body = document.getElementById("main-body");
    body.classList.toggle("dark-mode");
  }
</script>

</body>
</html>
