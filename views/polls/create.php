<h2>Create Poll</h2>

<form method="POST" action="/polls">
    <?= \App\Core\Csrf::field() ?>
    <div>
        <label for="question">Question</label>
        <input
            id="question"
            name="question"
            type="text"
            required
        >
    </div>

    <h3>Options</h3>

    <div id="options-container">
        <div class="option-field">
            <label for="option_1">Option 1</label>
            <input
                id="option_1"
                name="options[]"
                type="text"
                required
            >
        </div>

        <div class="option-field">
            <label for="option_2">Option 2</label>
            <input
                id="option_2"
                name="options[]"
                type="text"
                required
            >
        </div>
    </div>

    <button type="button" id="add-option-button">
        Add option
    </button>

    <button type="submit">Create Poll</button>
</form>

<p>
    <a href="/polls">Back to polls</a>
</p>

<script>
    const optionsContainer = document.getElementById('options-container');
    const addOptionButton = document.getElementById('add-option-button');

    let optionCount = 2;

    addOptionButton.addEventListener('click', function () {
        optionCount++;

        const optionWrapper = document.createElement('div');
        optionWrapper.className = 'option-field';

        const label = document.createElement('label');
        label.setAttribute('for', `option_${optionCount}`);
        label.textContent = `Option ${optionCount}`;

        const input = document.createElement('input');
        input.id = `option_${optionCount}`;
        input.name = 'options[]';
        input.type = 'text';
        input.required = true;
        optionWrapper.appendChild(label);
        optionWrapper.appendChild(input);

        optionsContainer.appendChild(optionWrapper);
    });
</script>