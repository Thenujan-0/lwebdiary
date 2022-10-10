import time

from selenium.webdriver.chrome.service import Service as ChromeService
import selenium
from selenium import webdriver

from webdriver_manager.chrome import ChromeDriverManager
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC 
from selenium.webdriver.support.ui import WebDriverWait

import pytest

ROOT="http://127.0.0.1:8000/"

def create_web_drvr():
    driver = webdriver.Chrome(service= ChromeService(ChromeDriverManager().install()))
    return driver

curr_drvr= None


def login(driver):
    email = driver.find_element(by=By.CSS_SELECTOR, value="#email")
    password =driver.find_element(by=By.CSS_SELECTOR,value = "#password")
    email.send_keys("test@gmail.com")
    password.send_keys("test")
    
    login = driver.find_element(by=By.CSS_SELECTOR, value="input[name='submit']")
    login.click()
    
    myElem = WebDriverWait(driver, 5).until(EC.presence_of_element_located((By.CSS_SELECTOR, '#btnExport')))
    
    
    

class Drvr():
    drivers={}
    
    def get_drvr(self,identity):
        
        if self.drivers.get(identity) is not None:
            return self.drivers.get(identity)
        else:
            self.drivers[identity]=create_web_drvr()
            return self.drivers.get(identity)
    
    def del_drvr(self,identity):
        self.drivers.pop(identity).quit()
    
    def del_all(self,sleep=0):
        time.sleep(sleep)
        for driver in self.drivers.values():
            driver.quit()



drvr= Drvr()

@pytest.fixture(scope="session", autouse=True)
def cleanup(request):
    """Cleanup a testing directory once we are finished."""
    def quit_all_drvrs():
        drvr.del_all(0)
    request.addfinalizer(quit_all_drvrs)