// Get the calculator screen
const screen = document.getElementById('screen');

let currentInput = ''; // To store the current input
let previousInput = ''; // To store the previous input
let operator = ''; // To store the operator

// Function to update the screen
function updateScreen(value) {
    screen.value = value;
}

// Add event listeners to all buttons
function handleClick(buttonId) {
    const button = document.getElementById(buttonId);
    const value = button.dataset.value; // Get the button's data-value attribute

    // If the AC button is clicked, clear everything
    if (buttonId === 'clear') {
        currentInput = '';
        previousInput = '';
        operator = '';
        updateScreen('');
        return;
    }

    // If the equals button is clicked, calculate the result
    if (buttonId === 'equals') {
        if (currentInput && previousInput && operator) {
            const result = calculate(Number(previousInput), Number(currentInput), operator);
            updateScreen(result);
            previousInput = result.toString();
            currentInput = '';
            operator = '';
        }
        return;
    }

    // If an operator button is clicked
    if (['+', '-', '*', '/'].includes(value)) {
        if (currentInput) {
            if (previousInput && operator) {
                // Calculate the intermediate result
                const result = calculate(Number(previousInput), Number(currentInput), operator);
                previousInput = result.toString();
                updateScreen(result);
            } else {
                previousInput = currentInput;
            }
            operator = value;
            currentInput = '';
        }
        return;
    }

    // If a number or dot button is clicked
    if (value === '.' && currentInput.includes('.')) {
        return; // Prevent multiple dots
    }

    currentInput += value;
    updateScreen(currentInput);
}

// Function to perform the calculation
function calculate(num1, num2, op) {
    switch (op) {
        case '+':
            return num1 + num2;
        case '-':
            return num1 - num2;
        case '*':
            return num1 * num2;
        case '/':
            return num2 !== 0 ? num1 / num2 : 'Error'; // Handle division by zero
        default:
            return 0;
    }
}
