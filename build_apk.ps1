$ErrorActionPreference = 'Stop'

$ENV_DIR = "C:\Users\Md Sadman Sakib\Android-Env"
$JDK_DIR = "$ENV_DIR\jdk"
$SDK_DIR = "$ENV_DIR\sdk"
$APP_DIR = "C:\Users\Md Sadman Sakib\Herd\Online-Bus-Ticket-Reservation-System\mobile-app"
$PROJECT_DIR = "$APP_DIR\android"

Write-Host "Creating Directories..."
if (!(Test-Path $ENV_DIR)) { New-Item -ItemType Directory -Path $ENV_DIR | Out-Null }
if (!(Test-Path $JDK_DIR)) { New-Item -ItemType Directory -Path $JDK_DIR | Out-Null }
if (!(Test-Path $SDK_DIR)) { New-Item -ItemType Directory -Path $SDK_DIR | Out-Null }

Write-Host "Downloading Amazon Corretto JDK 17..."
$jdkZip = "$ENV_DIR\amazon-corretto.zip"
if (!(Test-Path $jdkZip)) {
    Invoke-WebRequest -Uri "https://corretto.aws/downloads/latest/amazon-corretto-17-x64-windows-jdk.zip" -OutFile $jdkZip
}
Write-Host "Extracting JDK..."
if (!(Test-Path "$JDK_DIR\bin")) {
    Expand-Archive -Path $jdkZip -DestinationPath $JDK_DIR -Force
    # Corretto extracts into a subfolder like amazon-corretto-17... we need to move it up.
    $subfolders = Get-ChildItem -Path $JDK_DIR | Where-Object { $_.PSIsContainer }
    if ($subfolders.Count -gt 0) {
        $subfolder = $subfolders[0]
        Move-Item -Path "$($subfolder.FullName)\*" -Destination $JDK_DIR -Force
    }
}

Write-Host "Downloading Android SDK Command Line Tools..."
$sdkZip = "$ENV_DIR\cmdline-tools.zip"
if (!(Test-Path $sdkZip)) {
    Invoke-WebRequest -Uri "https://dl.google.com/android/repository/commandlinetools-win-11076708_latest.zip" -OutFile $sdkZip
}
Write-Host "Extracting SDK Tools..."
$cmdlineDir = "$SDK_DIR\cmdline-tools"
if (!(Test-Path "$cmdlineDir\latest")) {
    Expand-Archive -Path $sdkZip -DestinationPath $cmdlineDir -Force
    # Tools extract into a folder named "cmdline-tools". We must rename it to "latest" and put it under cmdline-tools.
    Rename-Item -Path "$cmdlineDir\cmdline-tools" -NewName "latest" -Force
}

$env:JAVA_HOME = $JDK_DIR
$env:ANDROID_HOME = $SDK_DIR
$env:Path = "$env:JAVA_HOME\bin;$env:ANDROID_HOME\cmdline-tools\latest\bin;$env:ANDROID_HOME\platform-tools;" + $env:Path

Write-Host "Accepting Android Licenses..."
Write-Output "y`ny`ny`ny`ny`ny`ny" | sdkmanager.bat --licenses

Write-Host "Installing Android Platforms and Build Tools..."
sdkmanager.bat "platform-tools" "platforms;android-34" "build-tools;34.0.0"

Write-Host "Syncing Capacitor to ensure everything is latest..."
cd $APP_DIR
npx cap sync android

Write-Host "Building APK..."
cd $PROJECT_DIR
.\gradlew assembleDebug

Write-Host "Moving APK to Desktop..."
$apkOrigin = "$PROJECT_DIR\app\build\outputs\apk\debug\app-debug.apk"
$apkDest = "C:\Users\Md Sadman Sakib\Desktop\SwiftBus_App.apk"

if (Test-Path $apkOrigin) {
    Copy-Item -Path $apkOrigin -Destination $apkDest -Force
    Write-Host "SUCCESS! APK copied to Desktop!"
} else {
    Write-Host "FAILED TO FIND COMPILED APK."
}
