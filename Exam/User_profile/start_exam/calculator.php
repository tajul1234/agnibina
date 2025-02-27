<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientific Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #f7f7f7;
        }

        .calculator {
            width: 400px;
            background: #1e293b;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        #display {
            width: 100%;
            height: 60px;
            font-size: 1.5rem;
            border: none;
            text-align: right;
            padding: 10px;
            box-sizing: border-box;
            background: #333;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .buttons button {
            width: 22%;
            height: 60px;
            font-size: 1.2rem;
            border: none;
            border-radius: 5px;
            background: #444;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .buttons button:hover {
            background: #575757;
        }

        .buttons .clear {
            background: #e63946;
        }

        .buttons .clear:hover {
            background: #d32f2f;
        }

        .buttons .equals {
            background: #1d3557;
        }

        .buttons .equals:hover {
            background: #14213d;
        }

        .buttons .function {
            background: #457b9d;
        }

        .buttons .function:hover {
            background: #1d3557;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <input type="text" id="display" placeholder="0" disabled>

        <div class="buttons">
            <!-- Number Buttons -->
            <button onclick="appendNumber('7')">7</button>
            <button onclick="appendNumber('8')">8</button>
            <button onclick="appendNumber('9')">9</button>
            <button onclick="appendOperator('+')" class="function">+</button>

            <button onclick="appendNumber('4')">4</button>
            <button onclick="appendNumber('5')">5</button>
            <button onclick="appendNumber('6')">6</button>
            <button onclick="appendOperator('-')" class="function">−</button>

            <button onclick="appendNumber('1')">1</button>
            <button onclick="appendNumber('2')">2</button>
            <button onclick="appendNumber('3')">3</button>
            <button onclick="appendOperator('*')" class="function">×</button>

            <button onclick="appendNumber('0')">0</button>
            <button onclick="appendOperator('.')">.</button>
            <button onclick="calculate()" class="equals">=</button>
            <button onclick="appendOperator('/')" class="function">÷</button>

            <!-- Operations -->
            <button onclick="appendOperator('sin(')" class="function">sin</button>
            <button onclick="appendOperator('cos(')" class="function">cos</button>
            <button onclick="appendOperator('tan(')" class="function">tan</button>
            <button onclick="toggleInverse()" class="function" id="inverse-btn">Inv</button>

            <button onclick="appendOperator('sqrt(')" class="function">√</button>
            <button onclick="appendOperator('^')">x^y</button>
            <button onclick="clearDisplay()" class="clear">C</button>
            <button onclick="deleteChar()" class="clear">DEL</button>
        </div>
    </div>

    <script>
        const display = document.getElementById("display");
        let inverse = false;

        function appendNumber(number) {
            if (display.value === "0") {
                display.value = number;
            } else {
                display.value += number;
            }
        }

        function appendOperator(operator) {
            if (inverse && (operator === 'sin(' || operator === 'cos(' || operator === 'tan(')) {
                operator = `Math.asin(${operator.slice(0, -1)}(`; // Add inverse logic
            }
            display.value += operator;
        }

        function clearDisplay() {
            display.value = "0";
        }

        function deleteChar() {
            display.value = display.value.slice(0, -1) || "0";
        }

        function calculate() {
            try {
                let result = display.value
                    .replace("sin", "Math.sin")
                    .replace("cos", "Math.cos")
                    .replace("tan", "Math.tan")
                    .replace("sqrt", "Math.sqrt")
                    .replace("^", "**");
                display.value = eval(result);
            } catch {
                display.value = "Error";
            }
        }

        function toggleInverse() {
            inverse = !inverse;
            const btn = document.getElementById("inverse-btn");
            btn.style.background = inverse ? "#ff6f61" : "#457b9d";
        }
    </script>
</body>
</html>
