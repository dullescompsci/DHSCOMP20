@echo off
set PC2INSTALL=%CD%
cd "%PC2INSTALL%\bin\"
:menu
cls

Set /a num=(%Random% %%9)+1

color %num%

echo             _____             _           _       
echo            / __  \           ^| ^|         (_)      
echo  _ __   ___`' / /'   __ _  __^| ^|_ __ ___  _ _ __  
echo ^| '_ \ / __^| / /    / _` ^|/ _` ^| '_ ` _ \^| ^| '_ \ 
echo ^| ^|_) ^| (__./ /___ ^| (_^| ^| (_^| ^| ^| ^| ^| ^| ^| ^| ^| ^| ^|
echo ^| .__/ \___\_____/  \__,_^|\__,_^|_^| ^|_^| ^|_^|_^|_^| ^|_^|
echo ^| ^|                                               
echo ^|_^|                                                
 


echo -------------------Current PC2 Dir-------------------- 
echo %PC2INSTALL%
echo -------------------------------------------------------
echo.
echo - - - Launch Tools - - -
echo 1) Start pc2 Server [pc2server] (1)
echo 2) Start pc2 Event Feed/Web Services client [pc2ef] (2)
echo 3) Launch pc2 Administrator client [pc2admin] (3)
echo 4) Launch pc2 Team client [pc2team] (4)
echo 5) Launch pc2 Judge client [pc2judge] (5)
echo 6) Launch pc2 AutoJudge client (HEADLESS) [pc2aj] (6)
echo 7) Launch pc2 Scoreboard client [pc2board] (7)
echo - - - Info Tools - - -
echo 8) Display current pc2 version [pc2ver] (8)
echo 9) Reports various pc2 reports (Offline) [pc2report] (9)
echo 10) Report/extract various information from a running pc2 server [pc2extract] (0)
echo 11) Create a ZIP file with all of the pc2 contest data [pc2zip] (q)
echo - - - Debug Tools - - -
echo 12) Launch netcat client for analytic/debugging [pc2nc] (w)
echo 13) Submit a run using CLI. (Probably not needed as an admin) [pc2submit] (e)
echo 14) Reset contest (Will delete all runs!!) [pc2reset] (r)
echo - - - - - - - - - - - - - - - - -
echo Type "x" to exit.
echo.
set /p web=Type option:
if "%web%"=="1" start pc2server.bat
if "%web%"=="2" start pc2ef.bat
if "%web%"=="3" start pc2admin.bat
if "%web%"=="4" start pc2team.bat
if "%web%"=="5" start pc2judge.bat
if "%web%"=="6" start pc2aj.bat
if "%web%"=="7" start pc2board.bat
if "%web%"=="8" start pc2ver.bat
if "%web%"=="9" start pc2report.bat
if "%web%"=="0" start pc2extract.bat
if "%web%"=="q" start pc2zip.bat
if "%web%"=="w" start pc2nc.bat
if "%web%"=="e" start pc2submit.bat
if "%web%"=="r" start pc2reset.bat
if "%web%"=="x" exit
goto menu