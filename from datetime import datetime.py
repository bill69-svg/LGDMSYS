from datetime import datetime
from pm4py.objects.msp_importer import importer as mpp_importer

# Load the Microsoft Project file
file_path = '/mnt/data/AWIL BILL DOMINIC.mpp'

try:
    project = mpp_importer.apply(file_path)
    project_info = {
        "start_date": project["global"]["start_date"],
        "end_date": project["global"]["end_date"],
        "tasks": len(project["tasks"]),
        "resources": len(project["resources"]),
    }
    project_info
except Exception as e:
    str(e)
