@echo off
echo Copying Fruitables template assets to Laravel public directory...

rem Create directories if they don't exist
mkdir "public\css" 2>nul
mkdir "public\js" 2>nul
mkdir "public\img" 2>nul
mkdir "public\lib" 2>nul
mkdir "public\scss" 2>nul

rem Copy CSS files
xcopy /s /y "fruitables-1.0.0\css\*.*" "public\css\"

rem Copy JS files
xcopy /s /y "fruitables-1.0.0\js\*.*" "public\js\"

rem Copy image files
xcopy /s /y "fruitables-1.0.0\img\*.*" "public\img\"

rem Copy library files
xcopy /s /y "fruitables-1.0.0\lib\*.*" "public\lib\"

rem Copy SCSS files
xcopy /s /y "fruitables-1.0.0\scss\*.*" "public\scss\"

echo Assets copied successfully!
