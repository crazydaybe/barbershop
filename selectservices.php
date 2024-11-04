<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Services</title>
    <link rel="stylesheet" type="text/css" href="selectservice.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="test.php"> 
                <img src="images/Profile.png" alt="Davidson's Barbershop Logo" class="logo-img">
            </a>
            <ul>
                <li><a href="services_count.php">Service Count And Total Cost</a></li>
                <!-- Removed Remit link -->
            </ul>
        </nav>

        <div class="main-content">
            <div id="servicesContainer">
                <div class="outer-box">
                    <div class="text">Haircut</div>
                    <div class="inners-box">
                        <button id="haircutBtn" onclick="selectItem('Haircut')">Select</button>
                    </div>
                </div>

                <div class="outer-box">
                    <div class="text">Hair Color</div>
                    <div class="inners-box">
                        <button id="hairColorBtn" onclick="selectItem('Hair Color')">Select</button>
                    </div>
                </div>

                <div class="outer-box">
                    <div class="text">Beard Trim</div>
                    <div class="inners-box">
                        <button id="beardTrimBtn" onclick="selectItem('Beard Trim')">Select</button>
                    </div>
                </div>

                <div class="outer-box">
                    <div class="text">All in 1 Services</div>
                    <div class="inners-box">
                        <button id="allInOneBtn" onclick="selectItem('All in 1 Services')">Select</button>
                    </div>
                </div>
            </div>

            <div class="inner-box">
                <form action="selectedservices.php" method="POST" onsubmit="return passSelectedServices(this);">
                    <input type="hidden" name="selectedServices" id="selectedServices">
                    <div class="submit-button-container">
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function selectItem(service) {
            let selectedServices = JSON.parse(localStorage.getItem('selectedServices')) || [];

            if (service === 'All in 1 Services') {
                document.getElementById('haircutBtn').disabled = true;
                document.getElementById('hairColorBtn').disabled = true;
                document.getElementById('beardTrimBtn').disabled = true;
            } else {
                document.getElementById('allInOneBtn').disabled = true;
            }

            if (!selectedServices.includes(service)) {
                selectedServices.push(service);
                localStorage.setItem('selectedServices', JSON.stringify(selectedServices));
                alert(service + ' Selected!');
            } else {
                alert(service + ' is already selected!');
            }

            updateSelectedServicesDisplay();
        }

        function updateSelectedServicesDisplay() {
            let selectedServices = JSON.parse(localStorage.getItem('selectedServices')) || [];
            let listElement = document.getElementById('selectedServicesList');
            
            listElement.innerHTML = '';

            selectedServices.forEach(function(service) {
                let listItem = document.createElement('li');
                listItem.textContent = service;
                listElement.appendChild(listItem);
            });
        }

        function passSelectedServices(form) {
            let selectedServices = JSON.parse(localStorage.getItem('selectedServices')) || [];

            if (selectedServices.length === 0) {
                alert('Please select a service first');
                return false;
            }

            form.selectedServices.value = selectedServices.join(',');

            localStorage.removeItem('selectedServices');

            return true;
        }

        window.onload = function() {
            updateSelectedServicesDisplay();
        }
    </script>
</body>
</html>
