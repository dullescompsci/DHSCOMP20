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
    if(file.endswith('.in')):
        newFile = file.replace('.in', '.dat')
        os.rename(file, newFile)

    elif (file.endswith('.ans')):
        newFile = file.replace('.ans', '.out')
        os.rename(file, newFile)
        
    if os.path.exists(newFile):
        print('%s already exists' % newFile)
        continue

    
    if (not os.path.exists(newFile)) or os.path.getsize(newFile) == 0:
        print('Failure')
        sys.exit()
    
