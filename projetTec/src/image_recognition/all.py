import os
from gender_recognition import *


if __name__ == "__main__" :
    cnn = build_cnn()
        
    if os.path.isdir('checkpoints'):
        #print("=> Loading checkpoint...")
        cnn.load_weights('./checkpoints/checkpoint_women_men')
        #print("Done !\n")

    nb_man = 0
    nb_woman = 0

    files = os.listdir("dataset_women_men/single_prediction")
    for img in files:
        test_file = "dataset_women_men/single_prediction/" + img
        if (int(predict_woman_man(test_file, cnn)) == 1):
            nb_man+=1
        else:
            nb_woman+=1

    
    print ("Nombre d'homme "+str(nb_man))
    print ("Nombre de femme "+str(nb_woman))




