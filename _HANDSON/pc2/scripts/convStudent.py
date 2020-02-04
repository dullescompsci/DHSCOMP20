import os, subprocess
import sys, re


allFiles = []
for root, _, files in os.walk('.'):
    root = root.replace('.', '')
    
    for file in files:
        if not file.endswith('.in') and not file.endswith('.ans'):
            continue

        file = os.path.join(root, file)
        allFiles.append(file)

print(allFiles)

for file in allFiles: 
    os.rename(file, "student_"+file)


    
