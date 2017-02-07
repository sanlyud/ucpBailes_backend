import requests
import time
from bs4 import BeautifulSoup
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.by import By
from selenium import webdriver
from selenium.webdriver.support.select import Select
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class ThinkCentralDataPull:

    loginURL = 'https://www-k6.thinkcentral.com/ePC/login.do'
    assignmentScoreURL = 'https://www-k6.thinkcentral.com/ePC/viewAllAssignments.do?method=viewAllAssignments&methodName=fromAssessments&selectedTopMenu=assessments'
    userName = None
    password = None
    className = None
    subjectName = None
    startDate = '08/01/16'
    # Initialize the end date to the current date (will get overwritten in the init if a value is provided)
    endDate = time.strftime("%x")

    def __init__(self, parserConfig):
        self.loginURL = parserConfig.loginURL
        self.assignmentScoreURL = parserConfig.dataURL
        self.userName = parserConfig.username
        self.password = parserConfig.password
        self.className = parserConfig.className
        self.subjectName = parserConfig.subjectName
        if parserConfig.startDate is not None:
            self.startDate = parserConfig.startDate
        if parserConfig.endDate is not None:
            self.endDate = parserConfig.endDate

    def gather(self):
        session = requests.Session()

        # Create the payload for the login page
        # This payload will be sent along with the post request and is used to fill out the fields of the login page
        payload = {'country': 'US',
                   'state': 'FL',
                   'district': '71111182',
                   'school': '10029206',
                   'loginpage': '',
                   'userName': self.userName,
                   'password': self.password,
                   # I thought these hidden fields needed to be added to the post request for it to submit the form correctly
                   # 'submit': 'Login2'
                   # Turns out the only hidden field needed was loginpage
                   # 'EPC_CSRF_TOKEN': '-3EQV-Z8RC-DJY2-D0V4-MGYW-ZABM-20A9-28CP-MFRD-7D8A-GRE5-KBXE-SQHJ-EL10-ODLH-TXNW-TM2S-A55Y-BW1P-DU2X-WI4W-4JH7-BNAT-DPDI',
                   # 'organizationId': '',
                   # 'REQUEST_TYPE': '',
                   # 'openToken': '',
                   # 'internationalUserLoginEnabled': 'true',
                   # 'urlChecklist': '',
                   # 'districtNameEval': '',
                   # 'selectedSchool': '',
                   }

        # Login to Think Central using the payload above
        loginPage = session.post(self.loginURL, payload)

        # Look up the class and subject value based on their name
        assignmentsPageFormFillOut = session.post(self.assignmentScoreURL)
        soup = BeautifulSoup(assignmentsPageFormFillOut.content, 'html.parser')

        # Get the html tag for the class drop down menu on the think central assignment page
        classSelectionDropDown = soup.find('select', attrs={'name':'studentclass'})
        # Look for a drop down item with the name provided from the user
        selectedClass = classSelectionDropDown.find(text=self.className)
        if selectedClass is None:
            exit('Could not find class specified')
        # Get the value of the html element for the drop down item
        # Parent gets the actual HTML tag where we found the className
        classID = selectedClass.parent['value']

        # Get the html tag for the subject drop down menu
        subjectSelectionDropDown = soup.find('select', attrs={'name': 'subject'})
        selectedSubject = subjectSelectionDropDown.find(text=self.subjectName)
        if selectedSubject is None:
            exit('Could not find subject specified')
        # Get the value of the html element for the drop down item
        subjectID = selectedClass.parent['value']

        # Create the payload to complete the form needed to view the assignment scores
        # The class ID used here corresponds to third grade math and the subject is Mathematics
        payload = {'selectedClass': classID,
                   'selectedSubject': subjectID,
                   'fromDate': self.startDate,
                   'toDate': self.endDate,
                   # 'viewAllAssignments': 'KXY9-UUKM-FH6C-48FN-ZNQL-IJMJ-4D05-A3Z3-EW06-1DGU-3MEW-C1RX-CB5C-AIDU-OVZH-JS11-QR1G-8MOH-UV5X-5PA0-MSVH-9T5N-WLRT-NN3J',
                   # 'classResults': 'UM28-R4IL-D9QY-IV0F-G2WF-6L5U-9NON-Q1GP-J882-ZPNC-WESG-JM7Z-G7TC-V3Z9-4RRP-7714-F6QW-W69K-FGS8-YFUA-ZYYA-8T3G-0GHT-W1X9',
                   # 'viewActivity': 'value="XTUI-9MUV-W7TH-RCV8-Q6DZ-DZTW-MZ3R-O0GX-RT5Q-AP2P-A2Y8-XPSE-6TF7-YH85-OBYL-9C9N-H9W5-ZT0V-8JCL-JSGI-B271-O8LB-59A9-SK9Y',
                   # 'viewAssignment': 'XPVE-1QN0-DC2O-ORDD-Q4HN-YNMI-LSE0-EP2C-EQCZ-9NWJ-ZZFV-SHTC-7F72-Q6XE-3QZD-7JFK-6RNZ-835R-HFX2-CCX9-92LG-JLFT-9GAC-JGW7',
                   # 'editActivityDetails': '45WS-J106-10PY-A8QL-39NO-5PW7-YEB2-605G-DIRJ-LZPN-4LL7-15VZ-W63W-340I-7MP6-RK3C-D5QT-FPLJ-M957-TRZM-9MWG-RBY3-D9NY-5589',
                   # 'editAssignmentDetails': 'editAssignmentDetails',
                   # 'editAdministratorsAssignmentDetails': '5B2A-YL2M-FPQK-0VQ3-EBI2-WCN5-0OWN-3AUN-TR0V-0Q0A-P1FY-1HPE-I7D9-V73V-9FAI-56WZ-AT87-AO5J-116H-Q6UD-KQ04-GHEG-V36K-Z5A2',
                   # 'AssignDetailsByTeacher': '7B6S-PF7C-H1DI-B94F-DKLE-QSPR-68VG-9VJJ-Y97E-UWOS-N3OE-IE6R-4WWD-4NYN-S544-54DY-GO8V-99AU-I3E3-C4J1-XLZE-T8IQ-CMX0-PGOS',
                   # 'searchPlanningContentsByUserTeacher': 'H1KN-NU7O-DN26-DJXA-BNBH-9B22-U3AK-VCFX-9IZC-0S02-SJ2S-Y9FW-PPJ6-UEUV-9X3R-K2GL-0I71-35C8-X9GQ-9M9W-A0IJ-YKW1-8IG4-PU6M',
                   # 'reOpenAssignmentId': '',
                   # 'reOpenDueDate': '',
                   # 'reOpenToolType': '',
                   # 'reOpenDescription': '',
                   # 'reOpenAssignmentType': '',
                   # 'methodName': 'FindClick',
                   # 'buttonClicked': 'true',
                   # 'userrole': 'TEACHER',
                   # 'isSoar': '-1',
                   # 'showOnlyAutoPrescriptions': 'false',
                   # 'showOnlyAssignments': 'false',
                   'find': 'Find'
                   }
        assignmentsPage = session.post(self.assignmentScoreURL, payload)
        print(assignmentsPage.content)

        # driver = webdriver.Firefox()
        # driver.maximize_window()
        #
        # driver.get(self.assignmentScoreURL)
        # wait = WebDriverWait(driver, 30)
        #
        # # paginate by 100
        # select = Select(driver.find_element_by_id("drhPageForm:drhPageTable:j_idt211:j_idt214:j_idt220"))
        # select.select_by_visible_text("100")
        #
        # while True:
        #     # wait until there is no loading spinner
        #     wait.until(EC.invisibility_of_element_located((By.ID, "loadingPopup_content_scroller")))
        #
        #     current_page = driver.find_element_by_class_name("rf-ds-act").text
        #     print("Current page: %d" % current_page)
        #
        #     # TODO: collect the results
        #
        #     # proceed to the next page
        #     try:
        #         next_page = driver.find_element_by_link_text(u"»")
        #         next_page.click()
        #     except NoSuchElementException:
        #         break

        with open('../Temp_Files/think_central_assignments.html', 'wb') as f:
            f.write(assignmentsPage.content)
