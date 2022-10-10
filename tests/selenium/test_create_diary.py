from libs.webdrivers import *

def test_create_diary():
    """ Checks if create diary button works fine """
    driver = drvr.get_drvr("create_diary")
    
    driver.get(ROOT)
    login(driver)