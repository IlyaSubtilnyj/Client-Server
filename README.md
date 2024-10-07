Клиент - сервер

Разработать простое приложения с рендерингом на сервере. 
Например, список задач со статусом их выполнения, фильтрацией по статусу и выставлением ожидаемой даты завершения, а так же возможностью прикреплять файлы к каждой задаче. 
Сервер должен отдавать клиенту готовую разметку, отправка данных серверу должна осуществляться через отправку форм.

Packages:
nikic/fast-route
league/plates
DDD

Build and run:
docker-compose up --build -d

CI/CD

To integrate PHPStan into your project using Visual Studio Code (VSCode), follow these steps:

### Step 1: Install PHPStan

1. **Open your terminal** in the root directory of your PHP project.
2. **Run the following command** to install PHPStan via Composer:

   ```bash
   composer require --dev phpstan/phpstan
   ```

### Step 2: Create a PHPStan Configuration File

1. **Create a configuration file** named `phpstan.neon` in your project root. This file allows you to customize PHPStan's behavior.

   Here's a basic example:

   ```neon
   parameters:
       level: 5  # You can set the level from 0 (least strict) to 8 (most strict)
       paths:
           - src  # Specify the directories to analyze
   ```

### Step 3: Run PHPStan from the Terminal

1. **Run PHPStan** using the following command:

   ```bash
   vendor/bin/phpstan analyse
   ```

   You can also specify paths directly:

   ```bash
   vendor/bin/phpstan analyse src
   ```

### Step 4: Integrate with VSCode

To get PHPStan's linting and error checking directly in VSCode, you can use the PHP Intelephense extension along with a few settings:

1. **Install PHP Intelephense**:
   - Go to the Extensions view in VSCode (Ctrl+Shift+X).
   - Search for "PHP Intelephense" and "phpstan(for live update)" and install it.

2. **Add PHPStan support**:
   - Open your VSCode settings (File > Preferences > Settings).
   - Search for `intelephense.environment.phpVersion` and set it to your PHP version (e.g., `7.4`).
   - You can also add a specific setting for PHPStan output, but generally, PHP Intelephense will work well with PHPStan's analysis.

### Step 5: Run PHPStan in VSCode Terminal

You can run PHPStan from the integrated terminal in VSCode to see the analysis results:

1. Open the integrated terminal (View > Terminal).
2. Run the PHPStan command:

   ```bash
   vendor/bin/phpstan analyse
   ```

### Optional: Setting Up a Task in VSCode

To make it easier to run PHPStan, you can set up a task in VSCode:

1. Go to the Command Palette (Ctrl+Shift+P) and type `Tasks: Configure Task`.
2. Choose `Create tasks.json file from template`.
3. Select `Others`.
4. Modify the generated `tasks.json` file to look like this:

   ```json
   {
       "version": "2.0.0",
       "tasks": [
           {
               "label": "Run PHPStan",
               "type": "shell",
               "command": "./vendor/bin/phpstan",
               "args": ["analyse", "src"],
               "group": {
                   "kind": "build",
                   "isDefault": true
               },
               "problemMatcher": ["$phpstan"],
               "detail": "Run PHPStan static analysis."
           }
       ]
   }
   ```

Now, you can run PHPStan easily by going to the Command Palette and selecting `Tasks: Run Task`, then choosing "Run PHPStan".
