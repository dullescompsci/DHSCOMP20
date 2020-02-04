@echo off

rem Purpose: print pc2 version number
rem Author : pc2@ecs.csus.edu
rem $HeadURL$

rem Windows 2000 and beyond syntax
set EWUBIN=%~dp0
if exist %EWUBIN%\ewenv.bat goto :continue

rem fallback to path (or current directory)
set EWUBIN=%0\..
if exist %EWUBIN%\ewenv.bat goto :continue

rem else rely on PC2INSTALL variable
set EWUBIN=%PC2INSTALL%\bin
if exist %EWUBIN%\ewenv.bat goto :continue

echo.
echo ERROR: Could not locate scripts.
echo.
echo Please set the variable EWUINSTALL to the location of
echo   the VERSION file (ex: c:\pc2-9.0.0)
echo.
pause
goto :end

:continue
call %EWUBIN%\ewenv.bat

java -Xms64M -Xmx768M -cp %libdir%\PC2JavaServer.jar edu.csus.pc2.ewuteam.Zip %1 %2 %3 %4 %5 %6 %7 %8 %9


:end
rem eof ewzip.bat $Id$
