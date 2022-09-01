import os
import subprocess
import threading
from time import sleep


import selenium

import pytest

from libs.webdrivers import *



def assert_home(drvr):
    elem = drvr.find_element(by=By.CSS_SELECTOR, value="#btnExport")
    assert elem is not None
    

    

def test_export():
    """ Check if a file named teraDiaryExport.json is downloaded when the export button is clicked """
    driver = drvr.get_drvr("export")
    driver.get("http://127.0.0.1:8000/")
    login(driver)
    
    
    downloadedExportsCount = subprocess.check_output("ls /home/thenujan/Downloads | grep 'teraDiaryExport.*\.json' | wc -l ",shell=True).decode()
    
    assert_no_exc(driver)
    exportBtn = driver.find_element_by_css_selector("#btnExport")
    exportBtn.click()
    assert_no_exc(driver)
    
    downloadedExportsCountNew = subprocess.check_output("ls /home/thenujan/Downloads | grep 'teraDiaryExport.*\.json' | wc -l ",shell=True).decode()
    
    assert int(downloadedExportsCountNew) - int(downloadedExportsCount) == 1
    HOME= os.getenv("HOME")
    
    
    driver.quit()

def assert_no_exc(drvr):
    """ Checks if there are no exceptions on debugbar """
    selector ="a.phpdebugbar-tab:nth-child(3) span.phpdebugbar-badge.phpdebugbar-visible"
    
    try:
        myElem = WebDriverWait(drvr, 5).until(EC.presence_of_element_located((By.CSS_SELECTOR, selector)))

        assert False
    except selenium.common.exceptions.TimeoutException :
        assert True

# def continue_no_exc(drvr):
#     def test_(drvr): 
#         while True:
#             assert_no_exc(drvr)
#     threading.Thread(target=test_, args=(drvr,)).start()




