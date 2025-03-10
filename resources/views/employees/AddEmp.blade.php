<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/AddEmp/AddEmp.css') }}" />
    <title>Employee Database Management System</title>
</head>
<style>
    :root {
    --btn: #dbdbdb;
    --btn-hover: #cacaca;
    --item-bg: #f0f0f0;
    --modal-bg: rgba(141, 141, 141, 0.541);
}

body {
    font-family: sans-serif;
    padding: 0 10px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header > button {
    padding: 10px 15px;
    border-radius: 20px;
    border: none;
    background-color: var(--btn);
    cursor: pointer;
}

.header > button:hover {
    background-color: var(--btn-hover);
}

.employees {
    display: flex;
}

.employees > div {
    border: 1px solid black;
    overflow-y: scroll;
    height: 450px;
}

.employees__names {
    width: 30%;
}

.employees__single {
    width: 70%;
}

.employees__names,
.employees__single {
    padding: 10px;
    display: flex;
    flex-direction: column;
}

.employees__names--title,
.employees__single--title {
    padding-bottom: 10px;
    margin-bottom: 5px;
    text-align: center;
    border-bottom: 1px solid black;
}

.employees__names--list {
    display: flex;
    flex-direction: column;
}

.employees__names--item {
    cursor: pointer;
    padding: 10px 15px;
    margin-bottom: 5px;
    text-align: center;
    background-color: var(--item-bg);
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.employees__names--item:hover,
.selected {
    background-color: var(--btn);
}

.employees__single--heading {
    text-align: center;
    font-size: 25px;
    text-transform: uppercase;
    padding: 5px;
}

.employees__single--info {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.employees__single--info > img {
    width: 250px;
    height: 250px;
    object-fit: contain;
    border-radius: 50%;
}

.addEmployee {
    display: none;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    justify-content: center;
    align-items: center;
    background-color: var(--modal-bg);
}

.addEmployee_create {
    width: 400px;
    background-color: white;
    box-shadow: 0 0 50px grey;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.addEmployee_create > div {
    display: grid;
    grid-template-columns: 48.1% 48.1%;
    column-gap: 15px;
}

.addEmployee_create input {
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid rgb(236, 236, 236);
}

.addEmployee_create input::-webkit-outer-spin-button,
.addEmployee_create input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.addEmployee_create--submit {
    padding: 10px !important;
    border-radius: 5px;
    border: none;
    background-color: var(--btn);
    cursor: pointer;
}

.addEmployee_create--submit:hover {
    background-color: var(--btn-hover);
}
</style>
<body>
    <div id="app">
        <header class="header">
            <h1>Employee Database Management</h1>
            <button class="createEmployee">
                Add Employee
            </button>
        </header>

        <div class="employees">
            <div class="employees__names">
                <span class="employees__names--title">
                    Employee List
                </span>
                <div class="employees__names--list"></div>
            </div>
            <div class="employees__single">
                <div class="employees__single--title">
                    Employee Information
                </div>
                <div class="employees__single--info"></div>
            </div>
        </div>

        <!-- Add Employee Code - START -->
        <div class="addEmployee">
            <form class="addEmployee_create">
                Add a new Employee
                <div>
                    <input type="text" name="firstName" placeholder="First Name" required />
                    <input type="text" name="lastName" placeholder="Last Name" required />
                </div>
                <input type="text" name="imageUrl" placeholder="Image URL (Optional)" />
                <input type="email" name="email" placeholder="Email" required />
                <input type="number" name="contactNumber" placeholder="Contact" required />
                <input type="number" name="salary" placeholder="Salary" required />
                <input type="text" name="address" placeholder="Address" required />
                <input type="date" name="dob" placeholder="Date of Birth" class="addEmployee_create--dob" required />
                <input type="submit" class="addEmployee_create--submit" value="Submit" />
            </form>
        </div>
        <!-- Add Employee Code - END -->
    </div>

    <script src="{{ asset('js/addEmp.js') }}">
        <script>
        (async function () {
    const data = await fetch("{{ asset('js/data.json') }}");
    const res = await data.json();

    let employees = res;
    let selectedEmployeeId = employees[0].id;
    let selectedEmployee = employees[0];

    const employeeList = document.querySelector(".employees__names--list");
    const employeeInfo = document.querySelector(".employees__single--info");

    // Add Employee - START
    const createEmployee = document.querySelector(".createEmployee");
    const addEmployeeModal = document.querySelector(".addEmployee");
    const addEmployeeForm = document.querySelector(".addEmployee_create");

    createEmployee.addEventListener("click", () => {
        addEmployeeModal.style.display = "flex";
    });

    addEmployeeModal.addEventListener("click", (e) => {
        if (e.target.className === "addEmployee") {
            addEmployeeModal.style.display = "none";
        }
    });

    // Set Employee age to be entered minimum 18 years
    const dobInput = document.querySelector(".addEmployee_create--dob");
    dobInput.max = `${new Date().getFullYear() - 18}-${new Date().toISOString().slice(5, 10)}`;

    addEmployeeForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(addEmployeeForm);
        const values = [...formData.entries()];
        let empData = {};
        values.forEach((val) => {
            empData[val[0]] = val[1];
        });
        empData.id = employees[employees.length - 1].id + 1;
        empData.age = new Date().getFullYear() - parseInt(empData.dob.slice(0, 4), 10);
        empData.imageUrl = empData.imageUrl || "gfg.png";
        employees.push(empData);
        renderEmployees();
        addEmployeeForm.reset();
        addEmployeeModal.style.display = "none";
    });
    // Add Employee - END

    // Select Employee Logic - START
    employeeList.addEventListener("click", (e) => {
        if (e.target.tagName === "SPAN" && selectedEmployeeId !== e.target.id) {
            selectedEmployeeId = e.target.id;
            renderEmployees();
            renderSingleEmployee();
        }
        // Employee Delete Logic - START
        if (e.target.tagName === "I") {
            employees = employees.filter((emp) => String(emp.id) !== e.target.parentNode.id);
            if (String(selectedEmployeeId) === e.target.parentNode.id) {
                selectedEmployeeId = employees[0]?.id || -1;
                selectedEmployee = employees[0] || {};
                renderSingleEmployee();
            }
            renderEmployees();
        }
        // Employee Delete Logic - END
    });
    // Select Employee Logic - END

    // Render All Employees Logic - START
    const renderEmployees = () => {
        employeeList.innerHTML = "";
        employees.forEach((emp) => {
            const employee = document.createElement("span");
            employee.classList.add("employees__names--item");
            if (parseInt(selectedEmployeeId, 10) === emp.id) {
                employee.classList.add("selected");
                selectedEmployee = emp;
            }
            employee.setAttribute("id", emp.id);
            employee.innerHTML = `${emp.firstName} ${emp.lastName} <i class="employeeDelete">&#10060;</i>`;
            employeeList.append(employee);
        });
    };
    // Render All Employees Logic - END

    // Render Single Employee Logic - START
    const renderSingleEmployee = () => {
        // Employee Delete Logic - START
        if (selectedEmployeeId === -1) {
            employeeInfo.innerHTML = "";
            return;
        }
        // Employee Delete Logic - END

        employeeInfo.innerHTML = `
        <img src="${selectedEmployee.imageUrl}" />
        <span class="employees__single--heading">
        ${selectedEmployee.firstName} ${selectedEmployee.lastName} (${selectedEmployee.age})
        </span>
        <span>${selectedEmployee.address}</span>
        <span>${selectedEmployee.email}</span>
        <span>Mobile - ${selectedEmployee.contactNumber}</span>
        <span>DOB - ${selectedEmployee.dob}</span>
      `;
    };
    // Render Single Employee Logic - END

    renderEmployees();
    if (selectedEmployee) renderSingleEmployee();
})();
    async function fetchEmployees() {
        const response = await fetch("{{ route('employees.index') }}");
        return await response.json();
    }

    async function addEmployee(employeeData) {
        const response = await fetch("{{ route('employees.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(employeeData)
        });
        return await response.json();
    }

    async function deleteEmployee(id) {
        const response = await fetch(`/employees/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        return await response.json();
    }

    document.addEventListener('DOMContentLoaded', async function () {
        let employees = await fetchEmployees();
        let selectedEmployeeId = employees[0]?.id;
        let selectedEmployee = employees[0];

        const employeeList = document.querySelector(".employees__names--list");
        const employeeInfo = document.querySelector(".employees__single--info");

        // Render all employees
        const renderEmployees = () => {
            employeeList.innerHTML = "";
            employees.forEach((emp) => {
                const employee = document.createElement("span");
                employee.classList.add("employees__names--item");
                if (selectedEmployeeId === emp.id) {
                    employee.classList.add("selected");
                    selectedEmployee = emp;
                }
                employee.setAttribute("id", emp.id);
                employee.innerHTML = `${emp.first_name} ${emp.last_name} <i class="employeeDelete">&#10060;</i>`;
                employeeList.append(employee);
            });
        };

        // Render single employee
        const renderSingleEmployee = () => {
            if (!selectedEmployee) {
                employeeInfo.innerHTML = "";
                return;
            }
            employeeInfo.innerHTML = `
                <img src="${selectedEmployee.image_url || 'default.png'}" />
                <span class="employees__single--heading">
                    ${selectedEmployee.first_name} ${selectedEmployee.last_name} (${selectedEmployee.age})
                </span>
                <span>${selectedEmployee.address}</span>
                <span>${selectedEmployee.email}</span>
                <span>Mobile - ${selectedEmployee.contact_number}</span>
                <span>DOB - ${selectedEmployee.dob}</span>
            `;
        };

        // Add employee logic
        const addEmployeeForm = document.querySelector(".addEmployee_create");
        addEmployeeForm.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData(addEmployeeForm);
            const employeeData = Object.fromEntries(formData.entries());
            const newEmployee = await addEmployee(employeeData);
            employees.push(newEmployee);
            renderEmployees();
            addEmployeeForm.reset();
            document.querySelector(".addEmployee").style.display = "none";
        });

        // Delete employee logic
        employeeList.addEventListener("click", async (e) => {
            if (e.target.classList.contains("employeeDelete")) {
                const id = e.target.parentNode.id;
                await deleteEmployee(id);
                employees = employees.filter(emp => emp.id != id);
                renderEmployees();
                if (selectedEmployeeId == id) {
                    selectedEmployeeId = employees[0]?.id;
                    selectedEmployee = employees[0];
                    renderSingleEmployee();
                }
            }
        });

        renderEmployees();
        renderSingleEmployee();
    });
</script>
    </script>
</body>

</html>