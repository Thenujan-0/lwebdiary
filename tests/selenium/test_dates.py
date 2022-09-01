
from datetime import datetime
from libs.webdrivers import *

def build_date(date_:str):
    return datetime(*[int(num) for num in date_.split("-")])

def test_order():
    """ Check if dates are in descending order """
    driver = drvr.get_drvr("order")
    
    driver.get("http://127.0.0.1:8000/")
    login(driver)
    
    dates = driver.find_elements(by=By.CSS_SELECTOR, value=".btn.btnDate")
    
    lastDate= None
    for date_ in dates:
        if lastDate is not None:
            assert build_date(date_.text) < build_date(lastDate)
        
        lastDate = date_.text
            
    
    